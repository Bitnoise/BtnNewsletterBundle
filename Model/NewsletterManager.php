<?php
namespace Btn\NewsletterBundle\Model;

class NewsletterManager extends Newsletter
{
    private $params;
    private $twig;

    public function __construct(array $params = array()) {
        $this->params = $params;
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


}