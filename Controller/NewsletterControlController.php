<?php

namespace Btn\NewsletterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Btn\NewsletterBundle\Entity\Newsletter;
use Btn\NewsletterBundle\Form\NewsletterControlType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Newsletter controller.
 *
 * @Route("/newsletter")
 */
class NewsletterControlController extends Controller
{
    /**
     * Lists all Newsletter entities.
     *
     * @Route("/", name="cp_newsletter")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BtnNewsletterBundle:Newsletter')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            10
        );

        $pagination->setTemplate('BtnCrudBundle:Pagination:default.html.twig');

        return array(
            'pagination' => $pagination,
        );
    }

    /**
     * Export all Newsletter entities.
     *
     * @Route("/export-csv", name="cp_newsletter_export")
     * @Template()
     */
    public function exportAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BtnNewsletterBundle:Newsletter')->findAll();

        $response = new Response();

        // Set headers
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', 'application/CSV');
        $response->headers->set('Content-Disposition', 'attachment;filename=csv-' . date('Y-d-m') . '.csv;');
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Connection', 'Close');
        // Send headers before outputting anything
        $response->sendHeaders();

        $sep = '";"';
        $eol = '"';
        $csv = '';
        $csvHeader = array('id', 'email');
        $csvContent = $eol . implode($sep, $csvHeader) . $eol ."\n";

        foreach ($entities as $entity) {
            $csvContent .= $eol . implode($sep, array($entity->getId(), $entity->getEmail())) . $eol . "\n";
        }

        return $response->setContent($csvContent);;
    }

    /**
     * Displays a form to create a new Newsletter entity.
     *
     * @Route("/new", name="cp_newsletter_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Newsletter();
        $form   = $this->createForm(new NewsletterControlType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Newsletter entity.
     *
     * @Route("/create", name="cp_newsletter_create")
     * @Method("POST")
     * @Template("BtnNewsletterBundle:NewsletterControl:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Newsletter();
        $form = $this->createForm(new NewsletterControlType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $msg = $this->get('translator')->trans('crud.flash.saved');
            $this->getRequest()->getSession()->getFlashBag()->set('success', $msg);

            return $this->redirect($this->generateUrl('cp_newsletter_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Newsletter entity.
     *
     * @Route("/{id}/edit", name="cp_newsletter_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BtnNewsletterBundle:Newsletter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Newsletter entity.');
        }

        $editForm = $this->createForm(new NewsletterControlType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Newsletter entity.
     *
     * @Route("/{id}/update", name="cp_newsletter_update")
     * @Method("POST")
     * @Template("BtnNewsletterBundle:NewsletterControl:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BtnNewsletterBundle:Newsletter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Newsletter entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new NewsletterControlType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $msg = $this->get('translator')->trans('crud.flash.saved');
            $this->getRequest()->getSession()->getFlashBag()->set('success', $msg);

            return $this->redirect($this->generateUrl('cp_newsletter_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Newsletter entity.
     *
     * @Route("/{id}/delete", name="cp_newsletter_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BtnNewsletterBundle:Newsletter')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Newsletter entity.');
            }

            $em->remove($entity);
            $em->flush();

            $msg = $this->get('translator')->trans('crud.flash.deleted');
            $this->getRequest()->getSession()->getFlashBag()->set('success', $msg);
        }

        return $this->redirect($this->generateUrl('cp_newsletter'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
