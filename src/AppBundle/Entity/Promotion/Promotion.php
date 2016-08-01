<?php

namespace AppBundle\Entity\Promotion;

use AppBundle\Entity\Student;
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
    public function addStudent(Student $student)
    {
        $this->students->add($student);
        $student->setPromotion($this);

        return $this;
    }

    /**
     * @param Student $student
     * @return Promotion
     */
    public function removeStudent($student)
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
    public function addYear(Year $year)
    {
        $this->years->add($year);
        $year->setPromotion($this);

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
}
