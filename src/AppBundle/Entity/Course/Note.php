<?php

namespace AppBundle\Entity\Course;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table(name="course\note")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Course\NoteRepository")
 */
class Note
{
    public function __construct()
    {
        $this->results = new ArrayCollection();
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="base", type="float")
     */
    private $base;

    /**
     * @var array
     *
     * @ORM\Column(name="scale", type="json_array")
     */
    private $scale;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Course\Course", inversedBy="notes")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Course\Result", mappedBy="notes")
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
     * @return Note
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
     * Set base
     *
     * @param float $base
     *
     * @return Note
     */
    public function setBase($base)
    {
        $this->base = $base;

        return $this;
    }

    /**
     * Get base
     *
     * @return float
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Set scale
     *
     * @param array $scale
     *
     * @return Note
     */
    public function setScale($scale)
    {
        $this->scale = $scale;

        return $this;
    }

    /**
     * Get scale
     *
     * @return array
     */
    public function getScale()
    {
        return $this->scale;
    }

    /**
     * @param Course $course
     * @return Note
     */
    public function setCourse(Course $course)
    {
        $this->course = $course;
        if ($this->course != null) {
            $this->course->addNote($this);
        }

        return $this;
    }

    /**
     * @return Course $course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param Result $result
     * @return Note
     */
    public function addResult(Result $result = null)
    {
        $this->results->add($result);
        if ($result->getNote() && $result->getNote()->getId() != $this->id) {
            $result->setNote($this);
        }

        return $this;
    }

    /**
     * @param Result $result
     * @return Note
     */
    public function removeResult($result)
    {
        $this->results->remove($result);
        $result->setNote(null);

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

