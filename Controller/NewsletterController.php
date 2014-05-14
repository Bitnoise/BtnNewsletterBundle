<?php

namespace Btn\NewsletterBundle\Controller;

use Btn\BaseBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class NewsletterController extends BaseController
{
    /**
     * @Route("/add-email", name="btn_newsletter_add_email")
     * @Template()
     */
    public function addEmailAction(Request $request)
    {
        $nl = $this->get('btn.newsletter');
        $msg = 'error';
        $form = $nl->getForm();

        if ($request->isMethod('POST') && $request->get($form->getName())) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $nl->addEmail($form->getData());
                $msg = 'success';
            }

            $this->setFlash('app.newsletter.' . $msg, $msg);
        }

        return $this->render($nl->getParam('template'), array('form' => $form->createView()));
    }

}
