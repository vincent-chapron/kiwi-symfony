<?php

namespace AppBundle\Entity\Ticket;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Ticket\MessageRepository")
 */
class Message
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ticket\Ticket", inversedBy="messages")
     * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id")
     */
    private $ticket;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="messages")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;

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
     * Set content
     *
     * @param string $content
     *
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param Ticket $ticket
     * @return Message
     */
    public function setTicket(Ticket $ticket)
    {
        $this->ticket = $ticket;
        if ($ticket != null) {
            $this->ticket->addMessage($this);
        }

        return $this;
    }

    /**
     * @return Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param User $owner
     * @return Message
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
        if ($owner != null) {
            $this->owner->addMessage($this);
        }

        return $this;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
