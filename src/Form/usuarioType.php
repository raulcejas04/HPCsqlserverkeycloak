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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\usuarioDispositivoType;

class usuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //print_r($options);
    $builder
        ->setDisabled($options['disabled'])
        ->add('usuarioDispositivo', CollectionType::class, [
            'entry_type' => usuarioDispositivoType::class,
            'allow_delete' => true,
            'allow_add' => true,
            'by_reference' => false,
            'entry_options' => ['label' => false ]
            ])
        //->add('apellido')
        //->add('nombre')
        //->add('idUserKeycloak')
        ->add('edit_entity', HiddenType::class, [ 'mapped'=>false, 'disabled'=>false, 'attr' => ['value' => '1'] ])
        ->add('save', SubmitType::class, [
            'label'=>'Guardar',
            'attr' => ['class' => 'btn btn-success' ]
        ])
;
    }
//( !$options['disabled'] ? '0' : '1' )
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => usuario::class,
        ]);
    }
}
