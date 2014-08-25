<?php

namespace Btn\NewsletterBundle\Controller;

use Btn\AdminBundle\Controller\CrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
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
        $entities = $this->getEntityProvider()->getRepository()->findAll();

        $response = new Response();

        // Set headers
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', 'application/CSV');
        $response->headers->set('Content-Disposition', 'attachment;filename=csv-'.date('Y-d-m').'.csv;');
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Connection', 'Close');
        // Send headers before outputting anything
        $response->sendHeaders();

        $sep = '";"';
        $eol = '"';
        $csv = '';
        $csvHeader = array('id', 'email');
        $csvContent = $eol.implode($sep, $csvHeader).$eol."\n";

        foreach ($entities as $entity) {
            $csvContent .= $eol.implode($sep, array($entity->getId(), $entity->getEmail())).$eol."\n";
        }

        return $response->setContent($csvContent);;
    }
}
