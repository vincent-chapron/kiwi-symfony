<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Ticket\Message;
use AppBundle\Entity\Ticket\Ticket;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    public function __construct()
    {
        parent::__construct();
        $this->tickets = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

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

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket\Message", mappedBy="owner")
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Ticket\Ticket", mappedBy="users", cascade={"persist"})
     */
    private $tickets;

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

    /**
     * @param Message $message
     * @return User
     */
    public function addMessage(Message $message = null)
    {
        $this->messages->add($message);
        if ($message->getOwner() && $message->getOwner()->getId() != $this->id) {
            $message->setOwner($this);
        }

        return $this;
    }

    /**
     * @param Message $message
     * @return User
     */
    public function removeMessage($message)
    {
        $this->messages->remove($message);
        $message->setOwner(null);

        return $this;
    }

    /**
     * @return ArrayCollection<Message>
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param Ticket $ticket
     * @return User
     */
    public function addTicket(Ticket $ticket = null)
    {
        $this->tickets->add($ticket);
        if ($ticket->getUsers() && !$ticket->getUsers()->contains($this)) {
            $ticket->addUser($this);
        }

        return $this;
    }

    /**
     * @param Ticket $ticket
     * @return User
     */
    public function removeTicket(Ticket $ticket)
    {
        $this->tickets->remove($ticket);
        $ticket->removeUser($this);

        return $this;
    }

    /**
     * @return ArrayCollection<Ticket>
     */
    public function getTickets()
    {
        return $this->tickets;
    }
}
