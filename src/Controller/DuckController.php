<?php

namespace App\Controller;

use App\Entity\Duck;
use App\Form\Duck1Type;
use App\Repository\DuckRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/duck")
 */
class DuckController extends AbstractController
{
    /**
     * @param Request $request
     *
     * @return Response
     * @Route("/", name="duck_profile", methods={"GET"})
     */
    public function profile(Request $request): Response {


        return  $this->render('duck/profile.html.twig', [
            'duck' => $this->getUser()
        ]);

    }
    /**
     * @Route("/admin", name="duck_index", methods={"GET"})
     */
    public function index(DuckRepository $duckRepository): Response
    {
        return $this->render('duck/index.html.twig', [
            'ducks' => $duckRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="duck_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $duck = new Duck();
        $form = $this->createForm(Duck1Type::class, $duck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($duck);
            $entityManager->flush();

            return $this->redirectToRoute('duck_index');
        }

        return $this->render('duck/new.html.twig', [
            'duck' => $duck,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="duck_show", methods={"GET"})
     */
    public function show(Duck $duck): Response
    {
        return $this->render('duck/show.html.twig', [
            'duck' => $duck,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="duck_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Duck $duck): Response
    {
        $form = $this->createForm(Duck1Type::class, $duck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('duck_index');
        }

        return $this->render('duck/edit.html.twig', [
            'duck' => $duck,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="duck_delete", methods={"POST"})
     */
    public function delete(Request $request, Duck $duck): Response
    {
        if ($this->isCsrfTokenValid('delete'.$duck->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($duck);
            $entityManager->flush();
        }

        return $this->redirectToRoute('duck_index');
    }


}
