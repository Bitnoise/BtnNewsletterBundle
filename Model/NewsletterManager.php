<?php
namespace Btn\NewsletterBundle\Model;

use Btn\NewsletterBundle\Form\NewsletterType;

class NewsletterManager
{
    private $params;
    private $twig;

    public function __construct(array $params = array(), $formFactory, $em) {
        $this->params = $params;
        $this->formFactory = $formFactory;
        $this->em = $em;
    }

    /**
     * function for get params
     *
     **/
    public function getParams() {
        return $this->params;
    }

    /**
     * function for get one item from params
     *
     **/
    public function getParam($key) {
        return $this->params[$key];
    }

    /**
     * function for set one item from params
     *
     **/
    public function setParam($key, $value) {
        return $this->params[$key] = $value;
    }

    /**
     * function for set params
     *
     **/
    public function setParams($params) {
        $this->params = $params;
    }

    /**
     * add email to database
     * @return Boolean
     **/
    public function addEmail($entity)
    {
        $exist = $this->em->getRepository('BtnNewsletterBundle:Newsletter')->findOneByEmail($entity->getEmail());

        if (!$exist) {
            $this->em->persist($entity);
            $this->em->flush();
        }

        return true;
    }

    /**
     *
     */
    public function createForm($data = null, array $options = array())
    {
        return $this->formFactory->create(new NewsletterType(), $data, $options);
    }
}
