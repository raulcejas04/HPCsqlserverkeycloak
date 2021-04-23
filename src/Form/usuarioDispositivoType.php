<?php

namespace App\Form;

use App\Entity\usuario;
use App\Entity\dispositivos;
use App\Entity\usuarioDispositivo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class usuarioDispositivoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //le saque el'multiple' => true, porque me pedia una collection
	$builder
            ->add('dispositivos', EntityType::class, [
                'class' => dispositivos::Class,
                'choice_label' => 'descripcion',
                'choice_value' => 'descripcion', //esto hace la magia (se llaman iguales)
                'placeholder' => 'Elegir un dispositivo',
            ])
            ->add('canRead', ChoiceType::class, [
                    'choices' => [
                        'No definido'=>null,
                        'Puede leer' => 'S',
                        'No puede leer' => 'N',
                    ],
                    'expanded'=>true,
                    'label_attr' => array(
                                'class' => 'radio-inline' ),
                    'multiple'=>false,
            ])
            ->add('canWrite', ChoiceType::class, [
                    'choices' => [
                        'No definido'=>null,
                        'Puede escribir' => 'S',
                        'No puede escribir' => 'N',
                       ],

                    'expanded'=>true,
                    'label_attr' => array(
                            'class' => 'radio-inline' ),
                    'multiple'=>false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => usuarioDispositivo::class,
        ]);
    }
}
