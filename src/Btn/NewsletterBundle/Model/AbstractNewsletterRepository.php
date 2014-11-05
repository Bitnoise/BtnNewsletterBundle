<?php

namespace Btn\NewsletterBundle\Model;

use Doctrine\ORM\EntityRepository;

abstract class AbstractNewsletterRepository extends EntityRepository
{
    public function getExportQuery()
    {
        return $this->createQueryBuilder('n')->getQuery();
    }
}
