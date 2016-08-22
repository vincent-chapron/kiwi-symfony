<?php

namespace AppBundle\Entity\Course;

use AppBundle\Entity\Student;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Result
 *
 * @ORM\Table(name="result")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Course\ResultRepository")
 */
class Result
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    public function getResult()
    {
        $result = 0;
        foreach ($this->value as $value) {
            $result += $value;
        }
        return $result;
    }

    public function getResultOnNoteBase()
    {
        $result = 0;
        foreach ($this->value as $value) {
            $result += $value;
        }

        $max = 0;
        foreach ($this->getNote()->getScale() as $scale) {
            if (array_key_exists("value", $scale)) {
                $max += $scale["value"];
            }
        };

        $result = ($result * $this->getNote()->getBase()) / $max;

        return $result;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(name="value", type="simple_array")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Course\Note", inversedBy="results")
     * @ORM\JoinColumn(name="note_id", referencedColumnName="id")
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Student", inversedBy="results")
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
     * Set value
     *
     * @param array $value
     *
     * @return Result
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return array
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param Note $note
     * @return Result
     */
    public function setNote(Note $note)
    {
        $this->note = $note;
        if ($this->note != null) {
            $this->note->addResult($this);
        }

        return $this;
    }

    /**
     * @return Note $note
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param Student $student
     * @return Result
     */
    public function setStudent(Student $student)
    {
        $this->student = $student;
        if ($this->student != null) {
            $this->student->addResult($this);
        }

        return $this;
    }

    /**
     * @return Student $student
     */
    public function getStudent()
    {
        return $this->student;
    }
}
