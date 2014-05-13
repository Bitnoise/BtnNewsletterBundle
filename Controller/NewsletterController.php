<?php

namespace Btn\AppBundle\Controller;

use Btn\BaseBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NeewsletterController extends BaseController
{
    /**
     * @Route("/add-email", name="btn_newsletter_add_email")
     * @Template()
     */
    public function addEmailAction(Request $request)
    {
        $nl = $this->get('btn.newsletter');

        if ($request->isMethod('POST')) {
            if ($nl->getForm()->isValid()) {
                $nl->addEmail($form->getData());
            }
        }

        //request get ref
        return $this->redirect('ref from request TODO', 301);
    }

}
