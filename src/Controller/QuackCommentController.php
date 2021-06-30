<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Entity\QuackComment;
use App\Form\QuackComment1Type;
use App\Repository\QuackCommentRepository;
use App\Service\SiteUpdateManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/quack/comment")
 */
class QuackCommentController extends AbstractController
{
    /**
     * @Route("/", name="quack_comment_index", methods={"GET"})
     */
    public function index(QuackCommentRepository $quackCommentRepository): Response
    {
        return $this->render('quack_comment/index.html.twig', [
            'quack_comments' => $quackCommentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="quack_comment_new", methods={"GET","POST"})
     */
    public function new(Request $request, Quack $quack): Response
    {
        $quackComment = new QuackComment();
        $quackComment->setQuack($quack);
        $quackComment->setAuthor($this->getUser());
        $form = $this->createForm(QuackComment1Type::class, $quackComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quackComment);
            $entityManager->flush();

            return $this->redirectToRoute('quack_index');
        }

        return $this->render('quack_comment/new.html.twig', [
            'quack_comment' => $quackComment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quack_comment_show", methods={"GET"})
     */
    public function show(QuackComment $quackComment): Response
    {
        return $this->render('quack_comment/show.html.twig', [
            'quack_comment' => $quackComment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="quack_comment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, QuackComment $quackComment): Response
    {
        $form = $this->createForm(QuackComment1Type::class, $quackComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quack_comment_index');
        }

        return $this->render('quack_comment/edit.html.twig', [
            'quack_comment' => $quackComment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quack_comment_delete", methods={"POST"})
     */
    public function delete(Request $request, QuackComment $quackComment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quackComment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quackComment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quack_comment_index');
    }

}
