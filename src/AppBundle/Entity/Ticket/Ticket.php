<?php

namespace AppBundle\Entity\Ticket;

use AppBundle\Entity\Student;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Ticket\TicketRepository")
 */
class Ticket
{
    use TimestampableEntity;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="close", type="boolean")
     */
    private $close;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket\Message", mappedBy="ticket")
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="tickets")
     */
    private $users;

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
     * Set close
     *
     * @param boolean $close
     *
     * @return Ticket
     */
    public function setClose($close)
    {
        $this->close = $close;

        return $this;
    }

    /**
     * Get close
     *
     * @return bool
     */
    public function getClose()
    {
        return $this->close;
    }

    /**
     * @param Message $message
     * @return Ticket
     */
    public function addMessage(Message $message = null)
    {
        $this->messages->add($message);
        if ($message->getTicket() && $message->getTicket()->getId() != $this->id) {
            $message->setTicket($this);
        }

        return $this;
    }

    /**
     * @param Message $message
     * @return Ticket
     */
    public function removeMessage($message)
    {
        $this->messages->remove($message);
        $message->setTicket(null);

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
     * @param User $user
     * @return Ticket
     */
    public function addUser(User $user = null)
    {
        $this->users->add($user);
        if ($user->getTickets() && !$user->getTickets()->contains($this)) {
            $user->addTicket($this);
        }

        return $this;
    }

    /**
     * @param User $user
     * @return Ticket
     */
    public function removeUser(User $user)
    {
        $this->users->remove($user);
        $user->removeTicket($this);

        return $this;
    }

    /**
     * @return ArrayCollection<User>
     */
    public function getUsers()
    {
        return $this->users;
    }
}

