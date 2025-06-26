<?php

namespace App\Adapter\Primary\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function __invoke(): Response
    {
        return $this->render('home.html.twig');
    }
}
