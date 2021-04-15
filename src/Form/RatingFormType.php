<?php


namespace App\Form;

use App\Entity\Rating;
use App\Entity\Resume;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class RatingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('resume', NumberType::class, [
                'required' => true
            ])
            ->add('status', NumberType::class, [
                'required' => true
            ])
            ->add('score', NumberType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Выберите оценку',
                    ],
                    ),
                    new Range([
                        'min' => 0,
                        'max' => 5,
                    ])
                ]
            ])
            ->add('comment', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Обязательное поле',
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rating::class,
        ]);
    }
}