<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GroupList
 *
 * @ORM\Table(name="group_list", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_group", columns={"id_group"})})
 * @ORM\Entity
 */
class GroupList
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="join_date", type="datetime", nullable=false)
     */
    private $joinDate;

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
     * Set joinDate
     *
     * @param \DateTime $joinDate
     *
     * @return GroupList
     */
    public function setJoinDate($joinDate)
    {
        $this->joinDate = $joinDate;

        return $this;
    }

    /**
     * Get joinDate
     *
     * @return \DateTime
     */
    public function getJoinDate()
    {
        return $this->joinDate;
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
     * @return GroupList
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
     * @return GroupList
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
