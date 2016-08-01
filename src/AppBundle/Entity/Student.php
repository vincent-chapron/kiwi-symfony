<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Internship\Internship;
use AppBundle\Entity\Promotion\Promotion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Student
 *
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StudentRepository")
 */
class Student
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    public function __construct()
    {
        $this->internships = new ArrayCollection();
    }

    /**
     * VIRTUAL PROPERTY
     * Get full name
     *
     * @return string
     */
    public function getFullName()
    {
        return "$this->firstname $this->lastname";
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
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_mobile", type="string", length=255, nullable=true)
     */
    private $phoneMobile;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Promotion\Promotion", inversedBy="students")
     * @ORM\JoinColumn(name="promotion_id", referencedColumnName="id")
     */
    private $promotion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Internship\Internship", mappedBy="student")
     */
    private $internships;

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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Student
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Student
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Student
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phoneMobile
     *
     * @param string $phoneMobile
     *
     * @return Student
     */
    public function setPhoneMobile($phoneMobile)
    {
        $this->phoneMobile = $phoneMobile;

        return $this;
    }

    /**
     * Get phoneMobile
     *
     * @return string
     */
    public function getPhoneMobile()
    {
        return $this->phoneMobile;
    }

    /**
     * @param Internship $internship
     * @return Student
     */
    public function addInternship($internship)
    {
        $this->internships->add($internship);
        $internship->setStudent($this);

        return $this;
    }

    /**
     * @param Promotion $promotion
     * @return Student
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * @return Promotion
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * @param Internship $internship
     * @return Student
     */
    public function removeInternship($internship)
    {
        $this->internships->remove($internship);
        $internship->setStudent(null);

        return $this;
    }

    /**
     * @return ArrayCollection<Internship>
     */
    public function getInternships()
    {
        return $this->internships;
    }
}
