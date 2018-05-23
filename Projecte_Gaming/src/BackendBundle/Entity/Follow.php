<?php

namespace BackendBundle\Entity;

/**
 * Follow
 */
class Follow
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
     * @var integer
     */
    private $idCommunity;

    /**
     * @var \DateTime
     */
    private $followdate;


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
     * @return Follow
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
     * Set idCommunity
     *
     * @param integer $idCommunity
     *
     * @return Follow
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
     * Set followdate
     *
     * @param \DateTime $followdate
     *
     * @return Follow
     */
    public function setFollowdate($followdate)
    {
        $this->followdate = $followdate;

        return $this;
    }

    /**
     * Get followdate
     *
     * @return \DateTime
     */
    public function getFollowdate()
    {
        return $this->followdate;
    }
}

