<?php

namespace PublicationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table(name="publication")
 * @ORM\Entity(repositoryClass="PublicationBundle\Repository\PublicationRepository")
 */
class Publication
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="canonical_title", type="string", nullable=true)
     */
    private $canonicalTitle;

    /**
     * @var int
     *
     * @ORM\Column(name="count_by_year", type="integer")
     */
    private $countByYear;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="text")
     */
    private $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="annual_cost", type="float")
     */
    private $annualCost;

    /**
     * @ORM\OneToMany(targetEntity="SubscriptionBundle\Entity\Subscription", mappedBy="publication")
     */
    private $subscriptions;

    function __construct()
    {
        $this->subscriptions = new ArrayCollection();
    }

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
     * @return string
     */
    public function getCanonicalTitle()
    {
        return $this->canonicalTitle;
    }

    /**
     * @param string $canonical_title
     */
    public function setCanonicalTitle($canonicalTitle)
    {
        $this->canonicalTitle = $canonicalTitle;
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

    /**
     * @return mixed
     */
    public function getSubscription()
    {
        return $this->subscriptions;
    }

    /**
     * @param mixed $subscriptions
     */
    public function setSubscription($subscriptions)
    {
        $this->subscriptions = $subscriptions;
    }
}

