<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Course\Result;
use AppBundle\Entity\Internship\Internship;
use AppBundle\Entity\Presence\Historic;
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
        $this->prospect = true;
        $this->internships = new ArrayCollection();
        $this->presences = new ArrayCollection();
        $this->results = new ArrayCollection();
    }

    /**
     * VIRTUAL PROPERTY
     * Get full name
     *
     * @return string
     */
    public function getFullName()
    {
        $forenames = implode(' ', array_map(function($name) {return ucfirst($name);}, explode(' ', $this->forenames)));
        $lastname = strtoupper($this->lastname);

        return "$forenames $lastname";
    }

    /**
     * VIRTUAL PROPERTY
     */
    public function getResultsWithCourses()
    {
        $courses = [];
        foreach ($this->results as $result) {
            /** @var Result $result */
            $key = $result->getNote()->getCourse()->getId();
            if (array_key_exists($key, $courses)) {
                $courses[$key]['results'][] = $result;
            } else {
                $courses[$key] = [
                    "course" => $result->getNote()->getCourse(),
                    "results" => [$result]
                ];
            }
        }
        return $courses;
    }

    /**
     * VIRTUAL PROPERTY
     * Get current status
     *
     * @return string
     */
    public function getCurrentStatus()
    {
        $presence = $this->getCurrentPresence();

        if (!$presence) return null;
        return $presence->getStatus() ? $presence->getStatus() : 'waiting';
    }

    /**
     * VIRTUAL PROPERTY
     * Is arrived ?
     *
     * @return boolean
     */
    public function isArrived()
    {
        $presence = $this->getCurrentPresence();

        if (!$presence) return null;
        return $presence->isArrived();
    }

    /**
     * VIRTUAL PROPERTY
     * Is left ?
     *
     * @return boolean
     */
    public function isLeft()
    {
        $presence = $this->getCurrentPresence();

        if (!$presence) return null;
        return $presence->isLeft();
    }

    public function getCurrentPresence() {
        $presences = $this->presences->filter(function($presence) {
            /** @var Historic $presence */
            $date = date("y-m-d", $presence->getCreatedAt()->getTimestamp());
            $today = date("y-m-d", strtotime("today"));

            return ($date === $today);
        });

        if (!count($presences)) return null;

        /** @var Historic $presence */
        $presence = $presences->first();
        return $presence;
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
     * @ORM\Column(name="social_number", type="string", length=255, unique=true, nullable=true)
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
     * @var boolean
     *
     * @ORM\Column(name="prospect", type="boolean")
     */
    private $prospect;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="student")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Presence\Historic", mappedBy="student")
     */
    private $presences;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Course\Result", mappedBy="student")
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
     * @param boolean $prospect
     * @return Student
     */
    public function setProspect($prospect)
    {
        $this->prospect = $prospect;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isProspect()
    {
        return $this->prospect;
    }

    /**
     * @param User $user
     * @return Student
     */
    public function setUser(User $user)
    {
        if ($user) {
            $this->user = $user;
            if (!($user->getStudent() && $user->getStudent()->getId() == $this->id)) {
                $user->setStudent($this);
            }
        }

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
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

    /**
     * @param Historic $presence
     * @return Student
     */
    public function addPresence(Historic $presence = null)
    {
        $this->presences->add($presence);
        if ($presence->getStudent() && $presence->getStudent()->getId() != $this->id) {
            $presence->setStudent($this);
        }

        return $this;
    }

    /**
     * @param Historic $presence
     * @return Student
     */
    public function removePresence($presence)
    {
        $this->presences->remove($presence);
        $presence->setStudent(null);

        return $this;
    }

    /**
     * @return ArrayCollection<Presence>
     */
    public function getPresences()
    {
        return $this->presences;
    }

    /**
     * @param Result $result
     * @return Student
     */
    public function addResult(Result $result = null)
    {
        $this->results->add($result);
        if ($result->getStudent() && $result->getStudent()->getId() != $this->id) {
            $result->setStudent($this);
        }

        return $this;
    }

    /**
     * @param Result $result
     * @return Student
     */
    public function removeResult($result)
    {
        $this->results->remove($result);
        $result->setStudent(null);

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
