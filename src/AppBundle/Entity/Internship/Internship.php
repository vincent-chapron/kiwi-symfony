<?php

namespace AppBundle\Entity\Internship;

use AppBundle\Entity\Student;
use AppBundle\Entity\Year\Year;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Internship
 *
 * @ORM\Table(name="internship")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Internship\InternshipRepository")
 */
class Internship
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    public function __construct()
    {
        $this->followUps = new ArrayCollection();
    }

    /**
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_at", type="date")
     */
    private $startAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_at", type="date")
     */
    private $endAt;

    /**
     * @var float
     *
     * @ORM\Column(name="weekly_time", type="float")
     */
    private $weeklyTime;

    /**
     * @var float
     *
     * @ORM\Column(name="total_days", type="float")
     */
    private $totalDays;

    /**
     * @var float
     *
     * @ORM\Column(name="schedule_gratification", type="float")
     */
    private $scheduleGratification;

    /**
     * @var string
     *
     * @ORM\Column(name="nature_advantages", type="text")
     */
    private $natureAdvantages;

    /**
     * @var string
     *
     * @ORM\Column(name="trainee_activities", type="text")
     */
    private $traineeActivities;

    /**
     * @var string
     *
     * @ORM\Column(name="trainee_service", type="string", length=255)
     */
    private $traineeService;

    /**
     * @var string
     *
     * @ORM\Column(name="first_contact", type="string", length=255)
     */
    private $firstContact;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="signed_at", type="date")
     */
    private $signedAt;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Year\Year", inversedBy="internships")
     * @ORM\JoinColumn(name="year_id", referencedColumnName="id")
     */
    private $year;   //TODO change with period

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Student", inversedBy="internships")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Internship\Company", inversedBy="internships")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Internship\Mentor", inversedBy="internships")
     * @ORM\JoinColumn(name="mentor_id", referencedColumnName="id")
     */
    private $mentor;

    /*
     * TODO: M to O -> SUPERVISOR
     */

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Internship\FollowUp", mappedBy="internship")
     */
    private $followUps;

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
     * Set startAt
     *
     * @param \DateTime $startAt
     *
     * @return Internship
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return \DateTime
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set endAt
     *
     * @param \DateTime $endAt
     *
     * @return Internship
     */
    public function setEndAt($endAt)
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get endAt
     *
     * @return \DateTime
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * @param Year $year
     * @return Internship
     */
    public function setYear(Year $year)
    {
        $this->year = $year;
        if ($this->year != null) {
            $this->year->addInternship($this);
        }

        return $this;
    }

    /**
     * @return Year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param Student $student
     * @return Internship
     */
    public function setStudent(Student $student)
    {
        $this->student = $student;
        if ($this->student != null) {
            $this->student->addInternship($this);
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

    /**
     * Set weeklyTime
     *
     * @param float $weeklyTime
     *
     * @return Internship
     */
    public function setWeeklyTime($weeklyTime)
    {
        $this->weeklyTime = $weeklyTime;

        return $this;
    }

    /**
     * Get weeklyTime
     *
     * @return float
     */
    public function getWeeklyTime()
    {
        return $this->weeklyTime;
    }

    /**
     * Set totalDays
     *
     * @param float $totalDays
     *
     * @return Internship
     */
    public function setTotalDays($totalDays)
    {
        $this->totalDays = $totalDays;

        return $this;
    }

    /**
     * Get totalDays
     *
     * @return float
     */
    public function getTotalDays()
    {
        return $this->totalDays;
    }

    /**
     * Set scheduleGratification
     *
     * @param float $scheduleGratification
     *
     * @return Internship
     */
    public function setScheduleGratification($scheduleGratification)
    {
        $this->scheduleGratification = $scheduleGratification;

        return $this;
    }

    /**
     * Get scheduleGratification
     *
     * @return float
     */
    public function getScheduleGratification()
    {
        return $this->scheduleGratification;
    }

    /**
     * Set natureAdvantages
     *
     * @param string $natureAdvantages
     *
     * @return Internship
     */
    public function setNatureAdvantages($natureAdvantages)
    {
        $this->natureAdvantages = $natureAdvantages;

        return $this;
    }

    /**
     * Get natureAdvantages
     *
     * @return string
     */
    public function getNatureAdvantages()
    {
        return $this->natureAdvantages;
    }

    /**
     * Set traineeActivities
     *
     * @param string $traineeActivities
     *
     * @return Internship
     */
    public function setTraineeActivities($traineeActivities)
    {
        $this->traineeActivities = $traineeActivities;

        return $this;
    }

    /**
     * Get traineeActivities
     *
     * @return string
     */
    public function getTraineeActivities()
    {
        return $this->traineeActivities;
    }

    /**
     * Set traineeService
     *
     * @param string $traineeService
     *
     * @return Internship
     */
    public function setTraineeService($traineeService)
    {
        $this->traineeService = $traineeService;

        return $this;
    }

    /**
     * Get traineeService
     *
     * @return string
     */
    public function getTraineeService()
    {
        return $this->traineeService;
    }

    /**
     * Set firstContact
     *
     * @param string $firstContact
     *
     * @return Internship
     */
    public function setFirstContact($firstContact)
    {
        $this->firstContact = $firstContact;

        return $this;
    }

    /**
     * Get firstContact
     *
     * @return string
     */
    public function getFirstContact()
    {
        return $this->firstContact;
    }

    /**
     * Set signedAt
     *
     * @param \DateTime $signedAt
     *
     * @return Internship
     */
    public function setSignedAt($signedAt)
    {
        $this->signedAt = $signedAt;

        return $this;
    }

    /**
     * Get signedAt
     *
     * @return \DateTime
     */
    public function getSignedAt()
    {
        return $this->signedAt;
    }

    /**
     * @param Mentor $mentor
     * @return Internship
     */
    public function setMentor(Mentor $mentor)
    {
        $this->mentor = $mentor;
        if ($mentor != null) {
            $this->mentor->addInternship($this);
        }

        return $this;
    }

    /**
     * @return Mentor
     */
    public function getMentor()
    {
        return $this->mentor;
    }

    /**
     * @param Company $company
     * @return Internship
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;
        if ($company != null) {
            $this->company->addInternship($this);
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

    /**
     * @param FollowUp $followUp
     * @return Internship
     */
    public function addFollowUp(FollowUp $followUp = null)
    {
        $this->followUps->add($followUp);
        if ($followUp->getInternship() && $followUp->getInternship()->getId() != $this->id) {
            $followUp->setInternship($this);
        }

        return $this;
    }

    /**
     * @param FollowUp $followUp
     * @return Internship
     */
    public function removeFollowUp($followUp)
    {
        $this->followUps->remove($followUp);
        $followUp->setInternship(null);

        return $this;
    }

    /**
     * @return ArrayCollection<FollowUp>
     */
    public function getFollowUps()
    {
        return $this->followUps;
    }
}
