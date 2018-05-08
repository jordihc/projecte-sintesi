<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Userchat
 *
 * @ORM\Table(name="userchat", indexes={@ORM\Index(name="id_user_e", columns={"id_user_e"}), @ORM\Index(name="id_user_e_2", columns={"id_user_e"}), @ORM\Index(name="id_user_e_3", columns={"id_user_e"}), @ORM\Index(name="id_user_r", columns={"id_user_r"})})
 * @ORM\Entity
 */
class Userchat
{
    /**
     * @var string
     *
     * @ORM\Column(name="missage", type="string", length=999, nullable=false)
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
     *   @ORM\JoinColumn(name="id_user_e", referencedColumnName="id")
     * })
     */
    private $idUserE;

    /**
     * @var \BackendBundle\Entity\InfoUsuario
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\InfoUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user_r", referencedColumnName="id")
     * })
     */
    private $idUserR;



    /**
     * Set missage
     *
     * @param string $missage
     *
     * @return Userchat
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
     * @return Userchat
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
     * Set idUserE
     *
     * @param \BackendBundle\Entity\InfoUsuario $idUserE
     *
     * @return Userchat
     */
    public function setIdUserE(\BackendBundle\Entity\InfoUsuario $idUserE = null)
    {
        $this->idUserE = $idUserE;

        return $this;
    }

    /**
     * Get idUserE
     *
     * @return \BackendBundle\Entity\InfoUsuario
     */
    public function getIdUserE()
    {
        return $this->idUserE;
    }

    /**
     * Set idUserR
     *
     * @param \BackendBundle\Entity\InfoUsuario $idUserR
     *
     * @return Userchat
     */
    public function setIdUserR(\BackendBundle\Entity\InfoUsuario $idUserR = null)
    {
        $this->idUserR = $idUserR;

        return $this;
    }

    /**
     * Get idUserR
     *
     * @return \BackendBundle\Entity\InfoUsuario
     */
    public function getIdUserR()
    {
        return $this->idUserR;
    }
}
