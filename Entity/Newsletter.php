<?php

namespace Btn\NewsletterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Btn\NewsletterBundle\Model\AbstractNewsletter;

/**
 * @ORM\Entity()
 * @ORM\Table(name="btn_newsletter")
 */
class Newsletter extends AbstractNewsletter
{
}
