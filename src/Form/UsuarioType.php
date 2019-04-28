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
            ->add('login', null, ["trim" => true])
            ->add('senha', null, ["label" => "Password"])
            ->add('name', null, ["label" => "Full name"])
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
