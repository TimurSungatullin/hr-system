<?php


namespace App\Form;

use App\Entity\Resume;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResumeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filePhoto', FileType::class, [
                'required' => false
            ])
            ->add('wage', NumberType::class, [
                'required' => false
            ])
            ->add('secondName', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Обязательное поле',
                    ])
                ]
            ])
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Обязательное поле',
                    ])
                ]
            ])
            ->add('patronymic', TextType::class, [
                'required' => false
            ])
            ->add('phone', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Обязательное поле',
                    ])
                ]
            ])
            ->add('birthdate', BirthdayType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Обязательное поле',
                    ])
                ]
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Обязательное поле',
                    ])
                ]
            ])
            ->add('graduation', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Обязательное поле',
                    ])
                ]
            ])
            ->add('workExperience', TextType::class, [
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
            'data_class' => Resume::class,
        ]);
    }
}