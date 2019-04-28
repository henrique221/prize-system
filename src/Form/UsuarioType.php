<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', null, ["trim" => true, "attr" => ["placeholder" => "login", "class" => "p-1"]])
            ->add('senha', null, ["label" => "Password", "attr" => ["placeholder" => "password", "class" => "p-1"]])
            ->add('name', null, ["label" => "Full name", "attr" => ["placeholder" => "full name", "class" => "p-1"]])
            ->add('permissoes', ChoiceType::class, array(
                "label" => "Permissions",
                "multiple" => true,
                "choices" => array("admin" => "ROLE_ADMIN", "user" => "ROLE_USER"),
                "expanded" => true,
                "attr" => ["class" => "d-flex","style" => 'font-family:"lato", sans-serif;']
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
