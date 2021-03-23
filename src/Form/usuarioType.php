<?php

namespace App\Form;

use App\Entity\usuario;
use App\Entity\dispositivos;
use App\Entity\usuarioDispositivo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\usuarioDispositivoType;

class usuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    $builder
        ->add('usuarioDispositivo', CollectionType::class, [
            'entry_type' => usuarioDispositivoType::class,
            'allow_delete' => true,
            'allow_add' => true,
            'by_reference' => false,
            ])
        ->add('apellido')
        ->add('nombre')
        ->add('idUserKeycloak');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => usuario::class,
        ]);
    }
}
