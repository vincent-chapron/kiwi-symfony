<?php

namespace AppBundle\Controller\Ticket;

use AppBundle\Entity\Beacon;
use AppBundle\Entity\Promotion\Promotion;
use AppBundle\Entity\Ticket\Message;
use AppBundle\Entity\Ticket\Ticket;
use AppBundle\Entity\User;
use AppBundle\Form\BeaconType;
use AppBundle\Form\Ticket\MessageType;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class TicketController extends FOSRestController
{
    /**
     * Récupération des Tickets.
     * @ApiDoc(
     *      resource = false,
     *      section = "Tickets"
     * )
     *
     * @View(serializerGroups={"Default"})
     * @return ArrayCollection<Ticket>
     */
    public function getTicketsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ticket_repository = $em->getRepository('AppBundle:Ticket\Ticket');
        $tickets = $ticket_repository->findBy(['close' => false]);

        return $tickets;
    }

    /**
     * Récupération des Tickets.
     * @ApiDoc(
     *      resource = false,
     *      section = "Tickets"
     * )
     *
     * @View(serializerGroups={"Default"})
     * @return ArrayCollection<Ticket>
     */
    public function getMeTicketsAction()
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user) throw new AuthenticationException();

        return $user->getTickets()->filter(function (Ticket $ticket) {
            return !$ticket->getClose();
        });
    }

    /**
     * Ajout d'un Ticket.
     * @ApiDoc(
     *      resource = false,
     *      section = "Tickets"
     * )
     *
     * @View(serializerGroups={"Default", "Ticket"})
     * @ParamConverter("user", class="AppBundle\Entity\User")
     * @param Request $request
     * @param User $user
     * @return Ticket
     */
    public function postUserTicketAction(Request $request, User $user)
    {
        $ticket = new Ticket();
        $message = new Message();

        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(MessageType::class, $message);
        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $ticket->setClose(false);
            $ticket->addUser($this->getUser());
            $ticket->addUser($user);

            $message->setTicket($ticket);
            $message->setOwner($this->getUser());

            $em->persist($ticket);
            $em->persist($message);
            $em->flush();

            return $ticket;
        }

        throw new BadRequestHttpException();
    }

    /**
     * Ajout d'un message à un Ticket.
     * @ApiDoc(
     *      resource = false,
     *      section = "Tickets"
     * )
     *
     * @View(serializerGroups={"Default", "Ticket"})
     * @ParamConverter("ticket", class="AppBundle\Entity\Ticket\Ticket")
     * @param Request $request
     * @param Ticket $ticket
     * @return Ticket
     */
    public function postTicketMessageAction(Request $request, Ticket $ticket)
    {
        // TODO: VOTER IS TICKET USER

        /** @var User $user */
        $user = $this->getUser();
        if (!$user || !$ticket->getUsers()->contains($user)) throw new AuthenticationException();

        $message = new Message();

        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(MessageType::class, $message);
        $form->submit($data);

        if ($form->isValid()) {
            $message->setTicket($ticket);
            $message->setOwner($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->persist($message);
            $em->flush();

            return $ticket;
        }

        throw new BadRequestHttpException();
    }
}
