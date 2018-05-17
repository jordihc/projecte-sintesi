<?php

namespace BackendBundle\Entity;

/**
 * InfoCommunity
 */
class InfoCommunity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $idAdmin;

    /**
     * @var string
     */
    private $description;

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
     * Set name
     *
     * @param string $name
     *
     * @return InfoCommunity
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set idAdmin
     *
     * @param integer $idAdmin
     *
     * @return InfoCommunity
     */
    public function setIdAdmin($idAdmin)
    {
        $this->idAdmin = $idAdmin;

        return $this;
    }

    /**
     * Get idAdmin
     *
     * @return integer
     */
    public function getIdAdmin()
    {
        return $this->idAdmin;
    }

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
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return InfoCommunity
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
     * @var string
     */
    private $imgAvatar = '/uploads/community/default.png';


    /**
     * Set imgAvatar
     *
     * @param string $imgAvatar
     *
     * @return InfoCommunity
     */
    public function setImgAvatar($imgAvatar)
    {
        $this->imgAvatar = $imgAvatar;

        return $this;
    }

    /**
     * Get imgAvatar
     *
     * @return string
     */
    public function getImgAvatar()
    {
        return $this->imgAvatar;
    }
}
