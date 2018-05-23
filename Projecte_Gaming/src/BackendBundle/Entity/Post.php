<?php

namespace BackendBundle\Entity;

/**
 * Post
 */
class Post
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $idUser;

    /**
     * @var \DateTime
     */
    private $createDate;

    /**
     * @var string
     */
    private $imgRoute;

    /**
     * @var string
     */
    private $messages;

    /**
     * @var string
     */
    private $imgAlt = 'img of post';


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
     * @param integer $idUser
     *
     * @return Post
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return integer
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

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
     * Set messages
     *
     * @param string $messages
     *
     * @return Post
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Get messages
     *
     * @return string
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set imgAlt
     *
     * @param string $imgAlt
     *
     * @return Post
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
}

