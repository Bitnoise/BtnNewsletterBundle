<?php
namespace Btn\NewsletterBundle\Twig;

class NewsletterExtension extends \Twig_Extension
{
    public function __construct($newsletter, $twig) {
        $this->newsletter = $newsletter;
        $this->twig = $twig;
    }

    public function getFunctions()
    {
        return array(
            'btn_nl' => new \Twig_Function_Method($this, 'render', array(
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
        $this->newsletter->setParams(array_replace($this->newsletter->getParams(), $arr));

        return $this->twig->render($this->newsletter->getParam('template'), array('form' => $this->newsletter->getForm()->createView()));
    }

    public function getName()
    {
        return 'newsletter_extension';
    }
}