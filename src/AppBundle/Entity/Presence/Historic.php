<?php

namespace AppBundle\Entity\Presence;

use AppBundle\Entity\Student;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Historic
 *
 * @ORM\Table(name="historic")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Presence\HistoricRepository")
 */
class Historic
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    public function __construct()
    {
        $this->arrived = false;
        $this->left = false;
        $this->status = null;
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
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_arrived", type="boolean")
     */
    private $arrived;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_left", type="boolean")
     */
    private $left;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Student", inversedBy="presences")
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
     * Set status
     *
     * @param string $status
     *
     * @return Historic
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set arrived
     *
     * @param boolean $arrived
     *
     * @return Historic
     */
    public function setArrived($arrived)
    {
        $this->arrived = $arrived;

        return $this;
    }

    /**
     * Get arrived
     *
     * @return bool
     */
    public function isArrived()
    {
        return $this->arrived;
    }

    /**
     * Set left
     *
     * @param boolean $left
     *
     * @return Historic
     */
    public function setLeft($left)
    {
        $this->left = $left;

        return $this;
    }

    /**
     * Get left
     *
     * @return bool
     */
    public function isLeft()
    {
        return $this->left;
    }

    /**
     * @param Student $student
     * @return Historic
     */
    public function setStudent(Student $student)
    {
        $this->student = $student;
        if ($this->student != null) {
            $this->student->addPresence($this);
        }

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
