<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login')
            ->add('senha', null, ["label" => "Password"])
            ->add('permissoes', ChoiceType::class, [
                "choices" => ["Admin" => "ROLE_ADMIN", "Funcionario" => "ROLE_FUNCIONARIO"],
                "label" => "Permissions",
                "attr" => ["class"=>"form-control", "style" => 'font-family:"lato", sans-serif;']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
