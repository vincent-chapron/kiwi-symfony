<?php

namespace AppBundle\Entity\Year;

use AppBundle\Entity\Promotion\Promotion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * Year
 *
 * @ORM\Table(name="year")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Year\YearRepository")
 */
class Year
{
    use SoftDeleteableEntity;

    public function __construct()
    {
        $this->periods = new ArrayCollection();
    }

    /**
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var String
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_at", type="date")
     */
    private $startAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_at", type="date")
     */
    private $endAt;

    /**
     * @ORM\OneToMany(targetEntity="Period", mappedBy="year")
     */
    private $periods;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Promotion\Promotion", inversedBy="years")
     * @ORM\JoinColumn(name="promotion_id", referencedColumnName="id")
     */
    private $promotion;

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
     * @param String $name
     * @return Year
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set startAt
     *
     * @param \DateTime $startAt
     *
     * @return Year
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return \DateTime
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set endAt
     *
     * @param \DateTime $endAt
     *
     * @return Year
     */
    public function setEndAt($endAt)
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get endAt
     *
     * @return \DateTime
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * @param Period $period
     * @return Year
     */
    public function addPeriod($period)
    {
        $this->periods->add($period);
        $period->setYear($this);

        return $this;
    }

    /**
     * @param Period $period
     * @return Year
     */
    public function removePeriod($period)
    {
        $this->periods->remove($period);
        $period->setYear(null);

        return $this;
    }

    /**
     * @return ArrayCollection<Period>
     */
    public function getPeriods()
    {
        return $this->periods;
    }

    /**
     * @param Promotion $promotion
     * @return Year
     */
    public function setPromotion(Promotion $promotion)
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * @return Promotion $promotion
     */
    public function getPromotion()
    {
        return $this->promotion;
    }
}
