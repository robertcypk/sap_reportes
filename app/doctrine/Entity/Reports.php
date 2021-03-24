<?php

namespace Entity;

/**
 * Reports
 */
class Reports
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $category;

    /**
     * @var integer
     */
    private $lang;

    /**
     * @var integer
     */
    private $cant;


    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $video;

    /**
     * @var integer
     */
    private $status;

     /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $created_at;

    /**
     * @var string
     */
    private $updated_at;


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
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Set title
     *
     * @param string $title
     *
     * @return Reports
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get category
     *
     * @return integer
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category
     *
     * @param integer $category
     *
     * @return Reports
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get lang
     *
     * @return integer
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set lang
     *
     * @param integer $lang
     *
     * @return Reports
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get cant
     *
     * @return integer
     */
    public function getCant()
    {
        return $this->cant;
    }

    /**
     * Set cant
     *
     * @param integer $cant
     *
     * @return Reports
     */
    public function setCant($cant)
    {
        $this->cant = $cant;

        return $this;
    }


    
    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Reports
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

     
    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set video
     *
     * @param string $video
     *
     * @return Reports
     */
    public function setVideo($video)
    {
        $this->video = $video;
        return $this;
    }


    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Reports
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    
    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return Reports
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return string
     */
    public function getCreatedat()
    {
        return $this->created_at;
    }

    /**
     * Set created_at
     *
     * @param string $created_at
     *
     * @return Reports
     */
    public function setCreatedat($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }


      /**
     * Get updated_at
     *
     * @return string
     */
    public function getUpdatedat()
    {
        return $this->updated_at;
    }

    /**
     * Set updated_at
     *
     * @param string $updated_at
     *
     * @return Reports
     */
    public function setUpdatedat($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

}
