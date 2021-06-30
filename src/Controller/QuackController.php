<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Form\Quack1Type;
use App\Repository\QuackCommentRepository;
use App\Repository\QuackRepository;
use App\Security\Voter\QuackVoter;
use App\Service\MailSender;
use phpDocumentor\Reflection\Types\This;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

/**
 * @Route("/quack")
 */
class QuackController extends AbstractController
{

    /**
     * @Route("/", name="quack_index", methods={"GET", "POST"})
     */
    public function index(QuackRepository $quackRepository, Request $request): Response
    {

        $value = $request->get('q');
        $quacks = 'quacks';
        if (isset($value) && !empty($value)) {

            $quacks = $quackRepository->findByExampleField($value);
        } else {
            $quacks = $quackRepository->findAll();
        }

        return $this->render('quack/index.html.twig',
            [
                'quacks' => $quacks,
            ]
        );
    }


    /**
     * @Route("/new", name="quack_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $quack = new Quack();
        $quack->setAuthor($this->getUser());
        $form = $this->createForm(Quack1Type::class, $quack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quack);
            $entityManager->flush();

            return $this->redirectToRoute('quack_index');
        }

        return $this->render('quack/new.html.twig', [
            'quack' => $quack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quack_show", methods={"GET"})
     */
    public function show(Request $request, Quack $quack, QuackCommentRepository $quackCommentRepository, NotifierInterface $notifier): Response
    {


        return $this->render('quack/show.html.twig', [
            'quack' => $quack,
        ]);

    }

    /**
     * @Route("/{id}/edit", name="quack_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quack $quack): Response
    {
        // check for "edit" access: calls all voters
        $this->denyAccessUnlessGranted(QuackVoter::QUACK_EDIT, $quack);

        // ...
        $form = $this->createForm(Quack1Type::class, $quack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quack_index');
        }

        return $this->render('quack/edit.html.twig', [
            'quack' => $quack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quack_delete", methods={"POST"})
     */
    public function delete(Request $request, Quack $quack): Response
    {
        if ($this->isCsrfTokenValid('delete' . $quack->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quack_index');
    }

    /**
     * @Route("/{id}/report", name="quack_report", methods={"GET"})
     */

    public function report(Quack $quack, MailSender $mailSender)
    {

        $mailSender->sendNewModerationRequest($quack);
      return $this->redirectToRoute('quack_show', [
            'id'=> $quack->getId(),
        ]);
    }
}
