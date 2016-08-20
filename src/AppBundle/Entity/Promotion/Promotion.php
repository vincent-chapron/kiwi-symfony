<?php

namespace AppBundle\Entity\Promotion;

use AppBundle\Entity\Beacon;
use AppBundle\Entity\Course\Course;
use AppBundle\Entity\Student;
use AppBundle\Entity\Year\Exception;
use AppBundle\Entity\Year\Period;
use AppBundle\Entity\Year\Year;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Promotion
 *
 * @ORM\Table(name="promotion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Promotion\PromotionRepository")
 */
class Promotion
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->years = new ArrayCollection();
        $this->courses = new ArrayCollection();
        $this->beacons = new ArrayCollection();
    }

    public function getCurrentYear()
    {
        foreach ($this->years as $year) {
            /** @var Year $year */
            $date = new \DateTime();
            $start_at = $year->getStartAt();
            $end_at = $year->getEndAt();

            if ($date >= $start_at && $date <= $end_at) return $year;
        }

        return null;
    }

    public function getCurrentPeriod()
    {
        if ($year = $this->getCurrentYear()) {
            foreach ($year->getPeriods() as $period) {
                /** @var Period $period */
                $date = new \DateTime();
                $start_at = $period->getStartAt();
                $end_at = $period->getEndAt();

                if ($date >= $start_at && $date <= $end_at) return $period;
            }
        }

        return null;
    }

    public function getCurrentException()
    {
        if ($year = $this->getCurrentYear()) {
            foreach ($year->getExceptions() as $exception) {
                /** @var Exception $exception */
                $date = new \DateTime();
                $start_at = $exception->getStartAt();
                $end_at = $exception->getEndAt();

                if ($date >= $start_at && $date <= $end_at) return $exception;
            }
        }

        return null;
    }

    /**
     * VIRTUAL PROPERTY
     * Get full name
     *
     * @return string
     */
    public function getStudentsCount()
    {
        return $this->students->count();
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Student", mappedBy="promotion")
     */
    private $students;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Year\Year", mappedBy="promotion")
     */
    private $years;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Course\Course", mappedBy="promotion")
     */
    private $courses;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Beacon", inversedBy="promotions")
     */
    private $beacons;

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
     * @return Promotion
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
     * @param Student $student
     * @return Promotion
     */
    public function addStudent(Student $student = null)
    {
        $this->students->add($student);
        if ($student->getPromotion() && $student->getPromotion()->getId() != $this->id) {
            $student->setPromotion($this);
        }

        return $this;
    }

    /**
     * @param Student $student
     * @return Promotion
     */
    public function removeStudent(Student $student)
    {
        $this->students->remove($student);
        $student->setPromotion(null);

        return $this;
    }

    /**
     * @return ArrayCollection<Student>
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * @param Year $year
     * @return Promotion
     */
    public function addYear(Year $year = null)
    {
        $this->years->add($year);
        if ($year->getPromotion() && $year->getPromotion()->getId() != $this->id) {
            $year->setPromotion($this);
        }

        return $this;
    }

    /**
     * @param Year $year
     * @return Promotion
     */
    public function removeYear(Year $year)
    {
        $this->years->remove($year);
        $year->setPromotion(null);

        return $this;
    }

    /**
     * @return ArrayCollection<Year>
     */
    public function getYears()
    {
        return $this->years;
    }

    /**
     * @param Course $course
     * @return Promotion
     */
    public function addCourse(Course $course = null)
    {
        $this->courses->add($course);
        if ($course->getPromotion() && $course->getPromotion()->getId() != $this->id) {
            $course->setPromotion($this);
        }

        return $this;
    }

    /**
     * @param Course $course
     * @return Promotion
     */
    public function removeCourse(Course $course)
    {
        $this->courses->remove($course);
        $course->setPromotion(null);

        return $this;
    }

    /**
     * @return ArrayCollection<Course>
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @param Beacon $beacon
     * @return Promotion
     */
    public function addBeacon(Beacon $beacon = null)
    {
        $this->beacons->add($beacon);
        if ($beacon->getPromotions() && !$beacon->getPromotions()->contains($this)) {
            $beacon->addPromotion($this);
        }

        return $this;
    }

    /**
     * @param Beacon $beacon
     * @return Promotion
     */
    public function removeBeacon(Beacon $beacon)
    {
        $this->beacons->remove($beacon);
        $beacon->removePromotion($this);

        return $this;
    }

    /**
     * @return ArrayCollection<Beacon>
     */
    public function getBeacons()
    {
        return $this->beacons;
    }
}
