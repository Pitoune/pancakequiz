<?php

namespace App\Adapter\Primary\Symfony\Form\Type;

use App\BusinessLogic\UseCase\Command\AddQuestionsToQuizCommand\AddQuestionsToQuizCommandRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddQuestionsToQuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('questions', CollectionType::class, [
                'required' => true,
                'entry_type' => QuestionType::class,
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => AddQuestionsToQuizCommandRequest::class,
            ]
        );
    }
}
