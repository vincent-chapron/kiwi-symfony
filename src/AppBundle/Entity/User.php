<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Student", mappedBy="user")
     */
    protected $student;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Student $student
     * @return user
     */
    public function setStudent(Student $student)
    {
        $this->student = $student;
        if (!($student->getUser() && $student->getUser()->getId() == $this->id)) {
            $student->setUser($this);
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
}
