<?php

namespace Btn\NewsletterBundle\Form\Factory;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use Btn\BaseBundle\Provider\EntityProviderInterface;
use Symfony\Component\Routing\RouterInterface;

class FormFactory
{
    /** @var \Symfony\Component\Form\FormFactoryInterface $formFactory */
    protected $formFactory;
    /** @var \Btn\BaseBundle\Provider\EntityProviderInterface $entityProvider */
    protected $entityProvider;
    /** @var \Symfony\Component\Routing\RouterInterface $router */
    protected $router;
    /** @var string $name */
    protected $name = 'btn_newsletter';
    /** @var string $type */
    protected $type = 'btn_newsletter_form_newsletter';

    /**
     *
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        EntityProviderInterface $entityProvider,
        RouterInterface $router
    ) {
        $this->formFactory    = $formFactory;
        $this->entityProvider = $entityProvider;
        $this->router         = $router;
    }

    /**
     *
     */
    public function createFormForRequest(Request $request, array $options = array())
    {
        if ($request && !isset($options['action']) && $request->attributes->has('_route_params')) {
            $options['action'] = $this->router->generate(
                $request->attributes->get('_route'),
                $request->attributes->get('_route_params', array())
            );
        }

        return $this->createForm($options);
    }

    /**
     *
     */
    public function createForm(array $options = array())
    {
        $entity = $this->entityProvider->create();

        return $this->formFactory->createNamed($this->name, $this->type, $entity, $options);
    }
}
