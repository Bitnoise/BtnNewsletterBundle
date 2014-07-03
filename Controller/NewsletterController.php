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

        $action = $this->generateUrl($request->attributes->get('_route'), $request->attributes->get('_route_params'));

        $form = $nl->createForm(null, array('action' => $action));
        $arr = array();

        if ($request->isMethod('POST') && $request->get($form->getName())) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $nl->addEmail($form->getData());
                $msg = 'success';
            }

            $arr['message'] = 'app.newsletter.' . $msg;
            $arr['msg_class'] = $msg;
        }

        $arr['form'] = $form->createView();

        return $this->render($nl->getParam('template'), $arr);
    }

}
