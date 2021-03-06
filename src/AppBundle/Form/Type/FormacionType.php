<?php

/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 25/04/17
 * Time: 10:51
 */
namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreCentro', TextType::class, [
                'label' => 'Nombre del centro',
                'required' => true,
                'attr' => [
                    'class' => 'form-centro',
                    'placeholder' => 'ej. Universidad de xxxx'
                ]
            ])
            ->add('titulacion', TextType::class, [
                'label' => 'Titulación',
                'required' => true,
                'attr' => [
                    'class' => 'form-titulacion',
                    'placeholder' => 'ej. Profesor de educación general'
                ]
            ])
            ->add('especialidad', TextType::class, [
                'label' => 'Especialidad',
                'required' => true,
                'attr' => [
                    'class' => 'form-especialidad',
                    'placeholder' => 'ej. Educación infantil'
                ]
            ])
            ->add('obtencion', DateType::class, [
                'label' => 'Fecha de obtención',
                'required' => true,
                'placeholder' => [
                    'month' => 'Mes', 'year' => 'Año'
                ],
                'years' => range(1970, Date('Y'))
            ]);
    }
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'formacion';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Formacion'
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_formacion';
    }
}