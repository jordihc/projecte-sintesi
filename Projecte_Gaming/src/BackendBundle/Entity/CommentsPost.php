<?php

namespace BackendBundle\Entity;

/**
 * CommentsPost
 */
class CommentsPost
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $idPost;

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
     * Set idPost
     *
     * @param integer $idPost
     *
     * @return CommentsPost
     */
    public function setIdPost($idPost)
    {
        $this->idPost = $idPost;

        return $this;
    }

    /**
     * Get idPost
     *
     * @return integer
     */
    public function getIdPost()
    {
        return $this->idPost;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return CommentsPost
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
     * @return CommentsPost
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
     * @return CommentsPost
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
