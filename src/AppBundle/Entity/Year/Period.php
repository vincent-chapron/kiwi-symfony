<?php

namespace AppBundle\Entity\Year;

use AppBundle\Entity\Course\Result;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * Period
 *
 * @ORM\Table(name="period")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Year\PeriodRepository")
 */
class Period
{
    use SoftDeleteableEntity;

    public function __construct()
    {
        $this->results = new ArrayCollection();
    }

    /**
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
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
     * @var string
     *
     * @ORM\Column(name="start_arrived_time", type="string", length=255)
     */
    private $startArrivedTime;

    /**
     * @var string
     *
     * @ORM\Column(name="end_arrived_time", type="string", length=255)
     */
    private $endArrivedTime;

    /**
     * @var string
     *
     * @ORM\Column(name="start_left_time", type="string", length=255)
     */
    private $startLeftTime;

    /**
     * @var string
     *
     * @ORM\Column(name="end_left_time", type="string", length=255)
     */
    private $endLeftTime;

    /**
     * @ORM\ManyToOne(targetEntity="Year", inversedBy="periods")
     * @ORM\JoinColumn(name="year_id", referencedColumnName="id")
     */
    private $year;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Course\Result", mappedBy="period")
     */
    private $results;

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
     * Set name
     *
     * @param string $name
     *
     * @return Period
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
     * Set startAt
     *
     * @param \DateTime $startAt
     *
     * @return Period
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
     * @return Period
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
     * @param mixed $startArrivedTime
     *
     * @return Period
     */
    public function setStartArrivedTime($startArrivedTime)
    {
        $this->startArrivedTime = $startArrivedTime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartArrivedTime()
    {
        return $this->startArrivedTime;
    }

    /**
     * @param mixed $endArrivedTime
     *
     * @return Period
     */
    public function setEndArrivedTime($endArrivedTime)
    {
        $this->endArrivedTime = $endArrivedTime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndArrivedTime()
    {
        return $this->endArrivedTime;
    }

    /**
     * @param mixed $startLeftTime
     *
     * @return Period
     */
    public function setStartLeftTime($startLeftTime)
    {
        $this->startLeftTime = $startLeftTime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartLeftTime()
    {
        return $this->startLeftTime;
    }

    /**
     * @param string $endLeftTime
     *
     * @return Period
     */
    public function setEndLeftTime($endLeftTime)
    {
        $this->endLeftTime = $endLeftTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getEndLeftTime()
    {
        return $this->endLeftTime;
    }

    /**
     * @param Year $year
     * @return Period
     */
    public function setYear(Year $year)
    {
        $this->year = $year;
        if ($this->year != null) {
            $this->year->addPeriod($this);
        }

        return $this;
    }

    /**
     * @return Year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param Result $result
     * @return Period
     */
    public function addResult(Result $result = null)
    {
        $this->results->add($result);
        if ($result->getPeriod() && $result->getPeriod()->getId() != $this->id) {
            $result->setPeriod($this);
        }

        return $this;
    }

    /**
     * @param Result $result
     * @return Period
     */
    public function removeResult($result)
    {
        $this->results->remove($result);
        $result->setPeriod(null);

        return $this;
    }

    /**
     * @return ArrayCollection<Result>
     */
    public function getResults()
    {
        return $this->results;
    }
}
