<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoCommunity
 *
 * @ORM\Table(name="info_community", indexes={@ORM\Index(name="game_id", columns={"game_id"}), @ORM\Index(name="admin_id", columns={"admin_id"})})
 * @ORM\Entity
 */
class InfoCommunity
{
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=999, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \BackendBundle\Entity\InfoGame
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\InfoGame")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="game_id", referencedColumnName="id")
     * })
     */
    private $game;

    /**
     * @var \BackendBundle\Entity\InfoUsuario
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\InfoUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="admin_id", referencedColumnName="id")
     * })
     */
    private $admin;



    /**
     * Set description
     *
     * @param string $description
     *
     * @return InfoCommunity
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * Set game
     *
     * @param \BackendBundle\Entity\InfoGame $game
     *
     * @return InfoCommunity
     */
    public function setGame(\BackendBundle\Entity\InfoGame $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \BackendBundle\Entity\InfoGame
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set admin
     *
     * @param \BackendBundle\Entity\InfoUsuario $admin
     *
     * @return InfoCommunity
     */
    public function setAdmin(\BackendBundle\Entity\InfoUsuario $admin = null)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return \BackendBundle\Entity\InfoUsuario
     */
    public function getAdmin()
    {
        return $this->admin;
    }
}
