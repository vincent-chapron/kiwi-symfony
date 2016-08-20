<?php

namespace AppBundle\Entity\Course;

use AppBundle\Entity\Promotion\Promotion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 *
 * @ORM\Table(name="course")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Course\CourseRepository")
 */
class Course
{
    public function __construct()
    {
        $this->notes = new ArrayCollection();
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Promotion\Promotion", inversedBy="courses")
     * @ORM\JoinColumn(name="promotion_id", referencedColumnName="id")
     */
    private $promotion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Course\Note", mappedBy="course")
     */
    private $notes;

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
     * @return Course
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
     * @param Promotion $promotion
     * @return Course
     */
    public function setPromotion(Promotion $promotion)
    {
        $this->promotion = $promotion;
        if ($this->promotion != null) {
            $this->promotion->addCourse($this);
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

    /**
     * @param Note $note
     * @return Course
     */
    public function addNote(Note $note = null)
    {
        $this->notes->add($note);
        if ($note->getCourse() && $note->getCourse()->getId() != $this->id) {
            $note->setCourse($this);
        }

        return $this;
    }

    /**
     * @param Note $note
     * @return Course
     */
    public function removeNote(Note $note)
    {
        $this->notes->remove($note);
        $note->setCourse(null);

        return $this;
    }

    /**
     * @return ArrayCollection<Note>
     */
    public function getNotes()
    {
        return $this->notes;
    }
}

