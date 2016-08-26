<?php

namespace AppBundle\Entity\Internship;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Mentor
 *
 * @ORM\Table(name="mentor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Internship\MentorRepository")
 */
class Mentor
{
    public function __construct()
    {
        $this->internships = new ArrayCollection();
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
     * @ORM\Column(name="fullname", type="string", length=255)
     */
    private $fullname;

    /**
     * @var string
     *
     * @ORM\Column(name="job", type="string", length=255)
     */
    private $job;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Internship\Internship", mappedBy="mentor")
     */
    private $internships;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Internship\Company", inversedBy="mentors")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;

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
     * Set fullname
     *
     * @param string $fullname
     *
     * @return Mentor
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set job
     *
     * @param string $job
     *
     * @return Mentor
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Mentor
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Mentor
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
     * @param Internship $internship
     * @return Mentor
     */
    public function addInternship(Internship $internship = null)
    {
        $this->internships->add($internship);
        if ($internship->getMentor() && $internship->getMentor()->getId() != $this->id) {
            $internship->setMentor($this);
        }

        return $this;
    }

    /**
     * @param Internship $internship
     * @return Mentor
     */
    public function removeInternship($internship)
    {
        $this->internships->remove($internship);
        $internship->setMentor(null);

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
     * @param Company $company
     * @return Mentor
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;
        if ($company != null) {
            $this->company->addMentor($this);
        }

        return $this;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }
}

