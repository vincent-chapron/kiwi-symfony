<?php

namespace AppBundle\Entity\Internship;

use AppBundle\Entity\Student;
use AppBundle\Entity\Year\Year;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Internship
 *
 * @ORM\Table(name="internship")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Internship\InternshipRepository")
 */
class Internship
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_at", type="datetime")
     */
    private $startAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_at", type="datetime")
     */
    private $endAt;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Year\Year")
     * @ORM\JoinColumn(name="year_id", referencedColumnName="id")
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Student", inversedBy="internships")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    private $student;

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
     * Set startAt
     *
     * @param \DateTime $startAt
     *
     * @return Internship
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
     * @return Internship
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
     * @param Year $year
     * @return Internship
     */
    public function setYear($year)
    {
        $this->year = $year;

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
     * @param Student $student
     * @return Internship
     */
    public function setStudent($student)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * @return Student
     */
    public function getStudent()
    {
        return $this->student;
    }
}

