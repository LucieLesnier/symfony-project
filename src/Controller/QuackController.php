<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Form\Quack1Type;
use App\Form\QuackType;
use App\Repository\QuackCommentRepository;
use App\Repository\QuackRepository;
use App\Security\Voter\QuackVoter;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

/**
 * @Route("/quack")
 */
class QuackController extends AbstractController
{

    /**
     * @Route("/", name="quack_index", methods={"GET"})
     */
    public function index(QuackRepository $quackRepository): Response
    {
        return $this->render('quack/index.html.twig', [
            'quacks' => $quackRepository->findAll(),
        ]);
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
    public function show(Request $request, Quack $quack, QuackCommentRepository $quackCommentRepository, NotifierInterface $notifier, string $photoDir): Response
    {
      /*  $form = $this->createForm(Quack1Type::class, $quack);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $notifier->send(new Notification('Can you check your submission? There are some problems with it.', ['browser']));
            $notifier->setAlert($this->addFlash());
        }
        $notifier->send(new Notification('This is not a common comment, it will be reach by an administrator.', ['browser'])); */
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
        if ($this->isCsrfTokenValid('delete'.$quack->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quack_index');
    }
}
