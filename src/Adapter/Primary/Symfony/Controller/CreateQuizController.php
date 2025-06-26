<?php

namespace App\Adapter\Primary\Symfony\Controller;

use App\Adapter\Primary\Symfony\Form\Type\CreateQuizType;
use App\BusinessLogic\UseCase\Command\CreateQuizzCommand\CreateQuizCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreateQuizController extends AbstractController
{
    #[Route('/{_locale}/quiz/create', name: 'quiz_create', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, CreateQuizCommandHandler $useCase): Response
    {
        $form = $this->createForm(CreateQuizType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $useCase->handle($form->getData());

            return $this->redirectToRoute('home');
        }

        return $this->render('quiz/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
