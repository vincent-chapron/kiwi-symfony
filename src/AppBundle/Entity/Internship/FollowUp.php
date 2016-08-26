<?php

namespace AppBundle\Entity\Internship;

use Doctrine\ORM\Mapping as ORM;

/**
 * FollowUp
 *
 * @ORM\Table(name="follow_up")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Internship\FollowUpRepository")
 */
class FollowUp
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
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Internship\Internship", inversedBy="followUps")
     * @ORM\JoinColumn(name="internship_id", referencedColumnName="id")
     */
    private $internship;

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
     * Set comment
     *
     * @param string $comment
     *
     * @return FollowUp
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param Internship $internship
     * @return FollowUp
     */
    public function setInternship(Internship $internship)
    {
        $this->internship = $internship;
        if ($internship != null) {
            $this->internship->addFollowUp($this);
        }

        return $this;
    }

    /**
     * @return Internship
     */
    public function getInternship()
    {
        return $this->internship;
    }
}

