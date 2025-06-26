<?php

namespace App\Adapter\Primary\Symfony\Controller;

use App\Adapter\Primary\Symfony\Form\Type\AddQuestionsToQuizType;
use App\BusinessLogic\UseCase\Command\AddQuestionsToQuizCommand\AddQuestionsToQuizCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddQuestionsToQuizController extends AbstractController
{
    #[Route('/{_locale}/quiz/{token}/add-questions', name: 'quiz_add_questions', methods: ['GET', 'POST'])]
    public function __invoke(
        AddQuestionsToQuizCommandHandler $useCase,
        Request $request,
        string $token,
    ): Response {
        $useCaseRequest = $useCase->prepareRequest($token);

        $form = $this->createForm(AddQuestionsToQuizType::class, $useCaseRequest);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $useCase->handle($useCaseRequest);

            return $this->redirectToRoute('home');
        }

        return $this->render('quiz/add-questions.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
