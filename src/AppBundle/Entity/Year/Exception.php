<?php

namespace AppBundle\Entity\Year;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exception
 *
 * @ORM\Table(name="exception")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Year\ExceptionRepository")
 */
class Exception
{
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
     * @ORM\Column(name="start_arrived_time", type="string", length=255, nullable=true)
     */
    private $startArrivedTime;

    /**
     * @var string
     *
     * @ORM\Column(name="end_arrived_time", type="string", length=255, nullable=true)
     */
    private $endArrivedTime;

    /**
     * @var string
     *
     * @ORM\Column(name="start_left_time", type="string", length=255, nullable=true)
     */
    private $startLeftTime;

    /**
     * @var string
     *
     * @ORM\Column(name="end_left_time", type="string", length=255, nullable=true)
     */
    private $endLeftTime;

    /**
     * @var bool
     *
     * @ORM\Column(name="presence_required", type="boolean")
     */
    private $presenceRequired;

    /**
     * @ORM\ManyToOne(targetEntity="Year", inversedBy="exceptions")
     * @ORM\JoinColumn(name="year_id", referencedColumnName="id")
     */
    private $year;

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
     * @return Exception
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
     * @return Exception
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
     * @return Exception
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
     * Set startArrivedTime
     *
     * @param string $startArrivedTime
     *
     * @return Exception
     */
    public function setStartArrivedTime($startArrivedTime)
    {
        $this->startArrivedTime = $startArrivedTime;

        return $this;
    }

    /**
     * Get startArrivedTime
     *
     * @return string
     */
    public function getStartArrivedTime()
    {
        return $this->startArrivedTime;
    }

    /**
     * Set endArrivedTime
     *
     * @param string $endArrivedTime
     *
     * @return Exception
     */
    public function setEndArrivedTime($endArrivedTime)
    {
        $this->endArrivedTime = $endArrivedTime;

        return $this;
    }

    /**
     * Get endArrivedTime
     *
     * @return string
     */
    public function getEndArrivedTime()
    {
        return $this->endArrivedTime;
    }

    /**
     * Set startLeftTime
     *
     * @param string $startLeftTime
     *
     * @return Exception
     */
    public function setStartLeftTime($startLeftTime)
    {
        $this->startLeftTime = $startLeftTime;

        return $this;
    }

    /**
     * Get startLeftTime
     *
     * @return string
     */
    public function getStartLeftTime()
    {
        return $this->startLeftTime;
    }

    /**
     * Set endLeftTime
     *
     * @param string $endLeftTime
     *
     * @return Exception
     */
    public function setEndLeftTime($endLeftTime)
    {
        $this->endLeftTime = $endLeftTime;

        return $this;
    }

    /**
     * Get endLeftTime
     *
     * @return string
     */
    public function getEndLeftTime()
    {
        return $this->endLeftTime;
    }

    /**
     * Set presenceRequired
     *
     * @param boolean $presenceRequired
     *
     * @return Exception
     */
    public function setPresenceRequired($presenceRequired)
    {
        $this->presenceRequired = $presenceRequired;

        return $this;
    }

    /**
     * Get presenceRequired
     *
     * @return bool
     */
    public function getPresenceRequired()
    {
        return $this->presenceRequired;
    }

    /**
     * @param Year $year
     * @return Exception
     */
    public function setYear(Year $year)
    {
        $this->year = $year;
        if ($this->year != null) {
            $this->year->addException($this);
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
}
