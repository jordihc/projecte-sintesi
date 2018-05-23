<?php

namespace BackendBundle\Entity;

/**
 * Noticia
 */
class Noticia
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $idCommunity;

    /**
     * @var \DateTime
     */
    private $createDate;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $imgRoute;

    /**
     * @var string
     */
    private $imgAlt = 'img of noticia';

    /**
     * @var string
     */
    private $message;


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
     * Set idCommunity
     *
     * @param integer $idCommunity
     *
     * @return Noticia
     */
    public function setIdCommunity($idCommunity)
    {
        $this->idCommunity = $idCommunity;

        return $this;
    }

    /**
     * Get idCommunity
     *
     * @return integer
     */
    public function getIdCommunity()
    {
        return $this->idCommunity;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return Noticia
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
     * Set title
     *
     * @param string $title
     *
     * @return Noticia
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set imgRoute
     *
     * @param string $imgRoute
     *
     * @return Noticia
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
     * Set imgAlt
     *
     * @param string $imgAlt
     *
     * @return Noticia
     */
    public function setImgAlt($imgAlt)
    {
        $this->imgAlt = $imgAlt;

        return $this;
    }

    /**
     * Get imgAlt
     *
     * @return string
     */
    public function getImgAlt()
    {
        return $this->imgAlt;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Noticia
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}

