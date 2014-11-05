<?php

namespace Btn\NewsletterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Btn\NewsletterBundle\Model\AbstractNewsletter;

/**
 * @ORM\Entity(repositoryClass="Btn\NewsletterBundle\Repository\NewsletterRepository")
 * @ORM\Table(name="btn_newsletter")
 */
class Newsletter extends AbstractNewsletter
{
}
