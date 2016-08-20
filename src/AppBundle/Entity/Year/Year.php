<?php

namespace AppBundle\Entity\Year;

use AppBundle\Entity\Internship\Internship;
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
        $this->exceptions = new ArrayCollection();
        $this->internships = new ArrayCollection();
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
     * @ORM\OneToMany(targetEntity="Exception", mappedBy="year")
     */
    private $exceptions;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Internship\Internship", mappedBy="year")
     */
    private $internships;

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
    public function addPeriod(Period $period = null)
    {
        $this->periods->add($period);
        if ($period->getYear() && $period->getYear()->getId() != $this->id) {
            $period->setYear($this);
        }

        return $this;
    }

    /**
     * @param Period $period
     * @return Year
     */
    public function removePeriod(Period $period)
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
     * @param Exception $exception
     * @return Year
     */
    public function addException(Exception $exception = null)
    {
        $this->exceptions->add($exception);
        if ($exception->getYear() && $exception->getYear()->getId() != $this->id) {
            $exception->setYear($this);
        }

        return $this;
    }

    /**
     * @param Exception $exception
     * @return Year
     */
    public function removeException(Exception $exception)
    {
        $this->exceptions->remove($exception);
        $exception->setYear(null);

        return $this;
    }

    /**
     * @return ArrayCollection<Exception>
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }

    /**
     * @param Internship $internship
     * @return Year
     */
    public function addInternship(Internship $internship = null)
    {
        $this->internships->add($internship);
        if ($internship->getYear() && $internship->getYear()->getId() != $this->id) {
            $internship->setYear($this);
        }

        return $this;
    }

    /**
     * @param Internship $internship
     * @return Year
     */
    public function removeInternship(Internship $internship)
    {
        $this->internships->remove($internship);
        $internship->setYear(null);

        return $this;
    }

    /**
     * @return ArrayCollection<Internship>
     */
    public function getInternships()
    {
        return $this->internships;
    }

    /**
     * @param Promotion $promotion
     * @return Year
     */
    public function setPromotion(Promotion $promotion)
    {
        $this->promotion = $promotion;
        if ($this->promotion != null) {
            $this->promotion->addYear($this);
        }

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
