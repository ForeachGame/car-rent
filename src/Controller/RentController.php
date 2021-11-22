<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RentController extends ApiController
{
    /**
     * @Route("/rent", name="rent")
     */
    public function index(): Response
    {
        return $this->render('rent/index.html.twig', [
            'controller_name' => 'RentController',
        ]);
    }
}
