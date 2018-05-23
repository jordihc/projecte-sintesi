<?php

namespace BackendBundle\Entity;

/**
 * CommentsNoticia
 */
class CommentsNoticia
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $idNoticia;

    /**
     * @var integer
     */
    private $idUser;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var \DateTime
     */
    private $createDate;


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
     * Set idNoticia
     *
     * @param integer $idNoticia
     *
     * @return CommentsNoticia
     */
    public function setIdNoticia($idNoticia)
    {
        $this->idNoticia = $idNoticia;

        return $this;
    }

    /**
     * Get idNoticia
     *
     * @return integer
     */
    public function getIdNoticia()
    {
        return $this->idNoticia;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return CommentsNoticia
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
     * Set comment
     *
     * @param string $comment
     *
     * @return CommentsNoticia
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return CommentsNoticia
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
}

