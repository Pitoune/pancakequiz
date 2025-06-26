<?php

namespace App\Adapter\Primary\Symfony\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question', TextType::class, [
                'required' => true,
            ])
            ->add('correct_answer', TextType::class, [
                'required' => true,
            ])
            ->add('wrong_answer_1', TextType::class, [
                'required' => true,
            ])
            ->add('wrong_answer_2', TextType::class, [
                'required' => true,
            ])
            ->add('wrong_answer_3', TextType::class, [
                'required' => true,
            ])
        ;
    }
}
