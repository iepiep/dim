<?php
declare(strict_types=1);
namespace DimSymfony\Controller\Admin;

use DimSymfony\Service\ItineraryService;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController; // Correct for this controller
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Db;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * @Route("/modules/dimsymfony/gestionrdv", name="admin_dimsymphony_gestionrdv_index")
 */
class DimSymfonyGestionRdvController extends FrameworkBundleAdminController
{
    private $itineraryService;
    private $googleApiKey;

    public function __construct(ItineraryService $itineraryService, string $googleApiKey)
    {
        $this->itineraryService = $itineraryService;
        $this->googleApiKey = $googleApiKey;
        parent::__construct();
    }

    /**
     * @Route("", methods={"GET", "POST"}, name="admin_dimsymphony_gestionrdv_index")
     */
    public function indexAction(Request $request): Response
    {
        $rdvs = Db::getInstance()->executeS(
            'SELECT * FROM `' . _DB_PREFIX_ . 'dim_rdv` ORDER BY date_creneau1 ASC'
        ) ?: [];

        $selectedIds = $request->request->get('selected', []);

        if ($request->isMethod('POST') && $request->request->has('generate_itinerary')) {
            if (empty($selectedIds) || !is_array($selectedIds)) {
                $this->addFlash('error', $this->trans('No appointments selected.', 'Modules.Dimsymfony.Admin'));
            } else {
                try {
                    $itineraryData = $this->itineraryService->calculateItinerary($selectedIds, $this->googleApiKey);

                    return $this->render('@Modules/dimsymfony/views/templates/admin/itinerary.html.twig', [
                        'optimized_route' => $itineraryData['optimized_route'],
                        'itinerary_schedule' => $itineraryData['itinerary_schedule'],
                        'google_maps_api_key' => $this->googleApiKey,
                    ]);
                } catch (\Exception $e) {
                    $this->addFlash('error', $this->trans('Error calculating itinerary: %error%', ['%error%' => $e->getMessage()], 'Modules.Dimsymfony.Admin'));
                }
            }
        }

        return $this->render('@Modules/dimsymfony/views/templates/admin/gestion_rdv.html.twig', [
            'rdvs' => $rdvs,
        ]);
    }
}