<?php

/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 25/04/17
 * Time: 10:51
 */
namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LaboralType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('empresa', TextType::class, [
                'label' => 'Nombre de la empresa',
                'required' => false,
                'attr' => [
                    'class' => 'form-empresa'
                ]
            ])
            ->add('actividad', ChoiceType::class, [
                'label' => '* Sexo',
                'required' => false,
                'choices'  => [
                    'Hombre' => 'H',
                    'Mujer' => 'M'
                ],
                'placeholder' => 'Selecciona una actividad',
                'attr' => [
                    'class' => 'form-actividad'
                ]
            ])
            ->add('puesto', TextType::class, [
                'label' => 'Puesto de trabajo',
                'required' => false,
                'attr' => [
                    'class' => 'form-puesto'
                ]
            ])
            ->add('tareas', TextType::class, [
                'label' => 'Tareas desempeñadas',
                'required' => false,
                'attr' => [
                    'class' => 'form-tareas'
                ]
            ])
            ->add('fechaInicio', BirthdayType::class, [
                'label' => 'Fecha de inicio (mm-aaaa)',
                'required' => false,
                'widget' => 'single_text',
                'format' => 'mm-yyyy',
                'placeholder' => [
                    'month' => 'Mes', 'year' => 'Año',
                ]
            ])
            ->add('fechaFin', BirthdayType::class, [
                'label' => 'Fecha de finalización (mm-aaaa)',
                'required' => false,
                'widget' => 'single_text',
                'format' => 'mm-yyyy',
                'placeholder' => [
                    'month' => 'Mes', 'year' => 'Año',
                ]
            ]);
    }
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'laboral';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Laboral'
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_laboral';
    }
}