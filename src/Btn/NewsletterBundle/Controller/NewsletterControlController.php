<?php

namespace Btn\NewsletterBundle\Controller;

use Btn\AdminBundle\Controller\CrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Goodby\CSV\Export\Standard\ExporterConfig;
use Goodby\CSV\Export\Standard\Exporter;
use Goodby\CSV\Export\Standard\Collection\CallbackCollection;
use Btn\AdminBundle\Annotation\Crud;

/**
 * @Route("/newsletter")
 * @Crud()
 */
class NewsletterControlController extends CrudController
{
    /**
     * Export all Newsletter entities.
     *
     * @Route("/export-csv", name="btn_newsletter_newslettercontrol_export")
     */
    public function exportAction()
    {
        $query = $this->getEntityProvider()->getRepository()->getExportQuery();
        $iterableResult = $query->iterate();

        $response = new StreamedResponse();
        $response->setStatusCode(200);
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment;filename=csv-'.date('Y-d-m').'.csv');
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Connection', 'Close');

        $response->setCallback(function() use($iterableResult) {
            $config     = new ExporterConfig();
            $exporter   = new Exporter($config);
            $collection = new CallbackCollection($iterableResult, function($row) {
                return array(
                    $row[0]->getId(),
                    $row[0]->getEmail(),
                );
            });

            $exporter->export('php://output', $collection);
        });

        $response->send();

        return $response;
    }
}
