<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * InfoGame
 *
 * @ORM\Table(name="info_game")
 * @ORM\Entity
 */
class Imatgeupload
{
    private $imatgeud;
    
    public function getImatgeud()
    {
        return $this->imatgeud;
    }
 
    public function setIatgeud($imatgeud)
    {
        $this->imatgeud = $imatgeud;
 
        return $this;
    }
}