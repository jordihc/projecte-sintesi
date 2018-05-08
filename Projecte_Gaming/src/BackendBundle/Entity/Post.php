<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="post", indexes={@ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Post
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime", nullable=false)
     */
    private $createDate;

    /**
     * @var string
     *
     * @ORM\Column(name="img_route", type="string", length=999, nullable=false)
     */
    private $imgRoute;

    /**
     * @var string
     *
     * @ORM\Column(name="video_route", type="string", length=999, nullable=false)
     */
    private $videoRoute;

    /**
     * @var string
     *
     * @ORM\Column(name="missage", type="string", length=999, nullable=false)
     */
    private $missage;

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
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return Post
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
     * Set imgRoute
     *
     * @param string $imgRoute
     *
     * @return Post
     */
    public function setImgRoute($imgRoute)
    {
        $this->imgRoute = $imgRoute;

        return $this;
    }

    /**
     * Get imgRoute
     *
     * @return string
     */
    public function getImgRoute()
    {
        return $this->imgRoute;
    }

    /**
     * Set videoRoute
     *
     * @param string $videoRoute
     *
     * @return Post
     */
    public function setVideoRoute($videoRoute)
    {
        $this->videoRoute = $videoRoute;

        return $this;
    }

    /**
     * Get videoRoute
     *
     * @return string
     */
    public function getVideoRoute()
    {
        return $this->videoRoute;
    }

    /**
     * Set missage
     *
     * @param string $missage
     *
     * @return Post
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
     * @return Post
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
}
