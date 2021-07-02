<?php

namespace App\Controller;

use App\Repository\QuackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @package App\Controller
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/quack", name="api_quack")
     */
    public function index(QuackRepository $quackRepository): Response
    {

        return $this->json($quackRepository->findAll(), 200, [], ['groups' => 'quack']);

    }

}

