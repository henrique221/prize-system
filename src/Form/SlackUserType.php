<?php

namespace App\Form;

use App\Entity\SlackUser;
use Doctrine\DBAL\Types\ArrayType;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlackUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null,
                ['label' => 'Name', 'attr' => ['style' => 'font-family:"lato", sans-serif;', 'class' => 'p-1']]
            )
            ->add('dataDeNascimento', null, ["label" => "Birthdate", "widget" => "single_text", "html5" => false, 'format' => "dd/MM/yyyy", "attr" => ['data-date-time' => true,"placeholder" => "DD/MM/AAAA" ,'style' => 'font-family:"lato", sans-serif;', 'class' => 'p-1 date']])
            ->add('email', EmailType::class, [
                'attr' => ['style' => 'font-family:"lato", sans-serif;', 'class' => 'p-1']
            ])
            ->add('startDate', null, ["widget" => "single_text", "html5" => false, 'format' => "dd/MM/yyyy", "attr" => ['data-date-time' => true,"placeholder" => "DD/MM/AAAA" ,'style' => 'font-family:"lato", sans-serif;', 'class' => 'p-1 date']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SlackUser::class,
        ]);
    }
}
