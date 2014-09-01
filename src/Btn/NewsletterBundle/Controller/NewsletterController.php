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

        $form = $this->get('btn_newsletter.form_factory')->createFormForRequest($request);

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
