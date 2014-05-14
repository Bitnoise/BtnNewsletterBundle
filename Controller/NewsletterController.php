<?php

namespace Btn\NewsletterBundle\Controller;

use Btn\BaseBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class NewsletterController extends BaseController
{
    /**
     * @Route("/add-email", name="btn_newsletter_add_email")
     * @Method("POST")
     * @Template()
     */
    public function addEmailAction(Request $request)
    {
        $nl = $this->get('btn.newsletter');
        $msg = false;
        $form = $nl->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $nl->addEmail($form->getData());
                $msg = 'success';
            }
        }

        $this->setFlash('app.newsletter.' . $msg, $msg);

        //request get ref
        return $this->redirect($request->headers->get('referer'), 301);
    }

}
