<?php

namespace PublicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Publication
{

    private $id;
    private $title;
    private $countByYear;
    private $picture;
    private $description;
    private $annualCost;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getCountByYear()
    {
        return $this->countByYear;
    }

    /**
     * @param int $countByYear
     */
    public function setCountByYear($countByYear)
    {
        $this->countByYear = $countByYear;
    }

    /**
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture($picture)
    {

        $this->picture = $picture;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getAnnualCost()
    {
        return $this->annualCost;
    }

    /**
     * @param float $annualCost
     */
    public function setAnnualCost($annualCost)
    {
        $this->annualCost = $annualCost;
    }
}

