<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groupchat
 *
 * @ORM\Table(name="groupchat", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_group", columns={"id_group"})})
 * @ORM\Entity
 */
class Groupchat
{
    /**
     * @var string
     *
     * @ORM\Column(name="missage", type="string", length=9999, nullable=false)
     */
    private $missage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime", nullable=false)
     */
    private $createDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \BackendBundle\Entity\InfoUsuario
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\InfoUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    /**
     * @var \BackendBundle\Entity\InfoGroup
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\InfoGroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_group", referencedColumnName="id")
     * })
     */
    private $idGroup;



    /**
     * Set missage
     *
     * @param string $missage
     *
     * @return Groupchat
     */
    public function setMissage($missage)
    {
        $this->missage = $missage;

        return $this;
    }

    /**
     * Get missage
     *
     * @return string
     */
    public function getMissage()
    {
        return $this->missage;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return Groupchat
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idUser
     *
     * @param \BackendBundle\Entity\InfoUsuario $idUser
     *
     * @return Groupchat
     */
    public function setIdUser(\BackendBundle\Entity\InfoUsuario $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \BackendBundle\Entity\InfoUsuario
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idGroup
     *
     * @param \BackendBundle\Entity\InfoGroup $idGroup
     *
     * @return Groupchat
     */
    public function setIdGroup(\BackendBundle\Entity\InfoGroup $idGroup = null)
    {
        $this->idGroup = $idGroup;

        return $this;
    }

    /**
     * Get idGroup
     *
     * @return \BackendBundle\Entity\InfoGroup
     */
    public function getIdGroup()
    {
        return $this->idGroup;
    }
}
