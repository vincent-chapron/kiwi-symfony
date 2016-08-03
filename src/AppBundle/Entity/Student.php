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
        return "$this->forenames $this->lastname";
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
     * @ORM\Column(name="forenames", type="string", length=255)
     */
    private $forenames;

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
     * @var string
     *
     * @ORM\Column(name="social_number", type="string", length=255, unique=true)
     */
    private $socialNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="assurance_name", type="string", length=255, nullable=true)
     */
    private $assuranceName;

    /**
     * @var string
     *
     * @ORM\Column(name="assurance_contract_number", type="string", length=255, nullable=true)
     */
    private $assuranceContractNumber;

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
     * Set forenames
     *
     * @param string $forenames
     *
     * @return Student
     */
    public function setForenames($forenames)
    {
        $this->forenames = $forenames;

        return $this;
    }

    /**
     * Get forenames
     *
     * @return string
     */
    public function getForenames()
    {
        return $this->forenames;
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
     * @param string $socialNumber
     * @return Student
     *
     */
    public function setSocialNumber($socialNumber)
    {
        $this->socialNumber = $socialNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getSocialNumber()
    {
        return $this->socialNumber;
    }

    /**
     * @param string $assuranceName
     * @return Student
     */
    public function setAssuranceName($assuranceName)
    {
        $this->assuranceName = $assuranceName;

        return $this;
    }

    /**
     * @return string
     */
    public function getAssuranceName()
    {
        return $this->assuranceName;
    }

    /**
     * @param string $assuranceContractNumber
     * @return Student
     */
    public function setAssuranceContractNumber($assuranceContractNumber)
    {
        $this->assuranceContractNumber = $assuranceContractNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getAssuranceContractNumber()
    {
        return $this->assuranceContractNumber;
    }

    /**
     * @param Promotion $promotion
     * @return Student
     */
    public function setPromotion(Promotion $promotion)
    {
        $this->promotion = $promotion;
        if ($promotion != null) {
            $this->promotion->addStudent($this);
        }

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
    public function addInternship(Internship $internship = null)
    {
        $this->internships->add($internship);
        if ($internship->getStudent() && $internship->getStudent()->getId() != $this->id) {
            $internship->setStudent($this);
        }

        return $this;
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
