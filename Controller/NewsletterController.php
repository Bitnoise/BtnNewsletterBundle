<?php

namespace Btn\NewsletterBundle\Controller;

use Btn\BaseBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/newsletter")
 */
class NewsletterController extends AbstractController
{
    /**
     * @Route("/new", name="btn_newsletter_newsletter_new")
     * @Route("/create", name="btn_newsletter_newsletter_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $message = '';
        $action  = '';

        $entity = $this->get('btn_newsletter.provider.newsletter')->create();

        if ($request->attributes->has('_route_params')) {
            $action = $this->generateUrl(
                $request->attributes->get('_route'),
                $request->attributes->get('_route_params', array())
            );
        }

        $form = $this->createForm('btn_newsletter_form_newsletter', $entity, array(
            'action' => $action,
        ));

        if ($this->get('btn_admin.form_handler')->handle($form, $request)) {
            $message = 'success';
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $message = 'error';
        }

        return array(
            'message' => $message ? 'btn_newsletter.message.'.$message : null,
            'form'    => $form->createView(),
        );
    }
}
