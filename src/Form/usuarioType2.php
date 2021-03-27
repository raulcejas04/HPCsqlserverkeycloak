<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UsuarioType2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    $builder
        ->add('idUserAd',TextType::class, ['label' => 'Nombre de usuario'])
        ->add('idUserKeycloak',TextType::class, ['label' => 'Id de Keycloack'])
        ->add('apellido',TextType::class, ['label' => 'Apellido'])
        ->add('nombre',TextType::class, ['label' => 'Nombre'])
        ->add('userActivo', CheckboxType::class)
        ->add('Agregar', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => usuario::class,
        ]);
    }
}
