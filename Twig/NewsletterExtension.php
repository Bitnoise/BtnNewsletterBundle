<?php
namespace Btn\BtnNewsletterBundle\Twig;

class NewsletterExtension extends \Twig_Extension
{
    public function __construct($manager, $twig) {
        $this->manager = $manager;
        $this->twig = $twig;
    }

    public function getFunctions()
    {
        return array(
            'btn_manager' => new \Twig_Function_Method($this, 'render', array(
                'is_safe' => array('html')
            ))
        );
    }

    /**
     * Render html
     *
     * @return Twig
     **/
    public function render($arr = array())
    {
        $this->manager->setParams(array_replace($this->manager->getParams(), $arr));

        return $this->twig->render($this->manager->getParam('template'), array('manager' => $this->manager));
    }

    public function getName()
    {
        return 'nl_extension';
    }
}