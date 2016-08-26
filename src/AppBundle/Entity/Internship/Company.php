<?php

namespace AppBundle\Entity\Internship;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Internship\CompanyRepository")
 */
class Company
{
    public function __construct()
    {
        $this->mentors = new ArrayCollection();
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
     * @ORM\Column(name="address", type="text")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="social_reason", type="string", length=255)
     */
    private $socialReason;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=255)
     */
    private $siret;

    /**
     * @var bool
     *
     * @ORM\Column(name="banned", type="boolean")
     */
    private $banned;

    /**
     * @var string
     *
     * @ORM\Column(name="representative_fullname", type="string", length=255)
     */
    private $representativeFullname;

    /**
     * @var string
     *
     * @ORM\Column(name="representative_job", type="string", length=255)
     */
    private $representativeJob;

    /**
     * @var string
     *
     * @ORM\Column(name="representative_phone", type="string", length=255)
     */
    private $representativePhone;

    /**
     * @var string
     *
     * @ORM\Column(name="representative_mail", type="string", length=255)
     */
    private $representativeMail;

    /**
     * @var string
     *
     * @ORM\Column(name="administration_fullname", type="string", length=255)
     */
    private $administrationFullname;

    /**
     * @var string
     *
     * @ORM\Column(name="administration_job", type="string", length=255)
     */
    private $administrationJob;

    /**
     * @var string
     *
     * @ORM\Column(name="administration_phone", type="string", length=255)
     */
    private $administrationPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="administration_mail", type="string", length=255)
     */
    private $administrationMail;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Internship\Mentor", mappedBy="company")
     */
    private $mentors;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Internship\Internship", mappedBy="company")
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
     * Set address
     *
     * @param string $address
     *
     * @return Company
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Company
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
     * Set socialReason
     *
     * @param string $socialReason
     *
     * @return Company
     */
    public function setSocialReason($socialReason)
    {
        $this->socialReason = $socialReason;

        return $this;
    }

    /**
     * Get socialReason
     *
     * @return string
     */
    public function getSocialReason()
    {
        return $this->socialReason;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Company
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Company
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set siret
     *
     * @param string $siret
     *
     * @return Company
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * Set banned
     *
     * @param boolean $banned
     *
     * @return Company
     */
    public function setBanned($banned)
    {
        $this->banned = $banned;

        return $this;
    }

    /**
     * Get banned
     *
     * @return bool
     */
    public function isBanned()
    {
        return $this->banned;
    }

    /**
     * Set representativeFullname
     *
     * @param string $representativeFullname
     *
     * @return Company
     */
    public function setRepresentativeFullname($representativeFullname)
    {
        $this->representativeFullname = $representativeFullname;

        return $this;
    }

    /**
     * Get representativeFullname
     *
     * @return string
     */
    public function getRepresentativeFullname()
    {
        return $this->representativeFullname;
    }

    /**
     * Set representativeJob
     *
     * @param string $representativeJob
     *
     * @return Company
     */
    public function setRepresentativeJob($representativeJob)
    {
        $this->representativeJob = $representativeJob;

        return $this;
    }

    /**
     * Get representativeJob
     *
     * @return string
     */
    public function getRepresentativeJob()
    {
        return $this->representativeJob;
    }

    /**
     * Set representativePhone
     *
     * @param string $representativePhone
     *
     * @return Company
     */
    public function setRepresentativePhone($representativePhone)
    {
        $this->representativePhone = $representativePhone;

        return $this;
    }

    /**
     * Get representativePhone
     *
     * @return string
     */
    public function getRepresentativePhone()
    {
        return $this->representativePhone;
    }

    /**
     * Set representativeMail
     *
     * @param string $representativeMail
     *
     * @return Company
     */
    public function setRepresentativeMail($representativeMail)
    {
        $this->representativeMail = $representativeMail;

        return $this;
    }

    /**
     * Get representativeMail
     *
     * @return string
     */
    public function getRepresentativeMail()
    {
        return $this->representativeMail;
    }

    /**
     * Set administrationFullname
     *
     * @param string $administrationFullname
     *
     * @return Company
     */
    public function setAdministrationFullname($administrationFullname)
    {
        $this->administrationFullname = $administrationFullname;

        return $this;
    }

    /**
     * Get administrationFullname
     *
     * @return string
     */
    public function getAdministrationFullname()
    {
        return $this->administrationFullname;
    }

    /**
     * Set administrationJob
     *
     * @param string $administrationJob
     *
     * @return Company
     */
    public function setAdministrationJob($administrationJob)
    {
        $this->administrationJob = $administrationJob;

        return $this;
    }

    /**
     * Get administrationJob
     *
     * @return string
     */
    public function getAdministrationJob()
    {
        return $this->administrationJob;
    }

    /**
     * Set administrationPhone
     *
     * @param string $administrationPhone
     *
     * @return Company
     */
    public function setAdministrationPhone($administrationPhone)
    {
        $this->administrationPhone = $administrationPhone;

        return $this;
    }

    /**
     * Get administrationPhone
     *
     * @return string
     */
    public function getAdministrationPhone()
    {
        return $this->administrationPhone;
    }

    /**
     * Set administrationMail
     *
     * @param string $administrationMail
     *
     * @return Company
     */
    public function setAdministrationMail($administrationMail)
    {
        $this->administrationMail = $administrationMail;

        return $this;
    }

    /**
     * Get administrationMail
     *
     * @return string
     */
    public function getAdministrationMail()
    {
        return $this->administrationMail;
    }

    /**
     * @param Internship $internship
     * @return Company
     */
    public function addInternship(Internship $internship = null)
    {
        $this->internships->add($internship);
        if ($internship->getCompany() && $internship->getCompany()->getId() != $this->id) {
            $internship->setCompany($this);
        }

        return $this;
    }

    /**
     * @param Internship $internship
     * @return Company
     */
    public function removeInternship($internship)
    {
        $this->internships->remove($internship);
        $internship->setCompany(null);

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
     * @param Mentor $mentor
     * @return Company
     */
    public function addMentor(Mentor $mentor = null)
    {
        $this->mentors->add($mentor);
        if ($mentor->getCompany() && $mentor->getCompany()->getId() != $this->id) {
            $mentor->setCompany($this);
        }

        return $this;
    }

    /**
     * @param Mentor $mentor
     * @return Company
     */
    public function removeMentor($mentor)
    {
        $this->mentors->remove($mentor);
        $mentor->setCompany(null);

        return $this;
    }

    /**
     * @return ArrayCollection<Mentor>
     */
    public function getMentors()
    {
        return $this->mentors;
    }
}

