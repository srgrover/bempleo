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
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
                'required' => true,
                'attr' => [
                    'class' => 'form-empresa'
                ]
            ])
            ->add('actividad', ChoiceType::class, [
                'label' => 'Actividad de la empresa',
                'required' => true,
                'choices'  => [
                    'Ganadería y pesca' => 'Ganadería y pesca',
                    'Energía y agua' => 'Energía y agua',
                    'Industr. transformad.' => 'Industr. transformad.',
                    'Productos industriales' => 'Productos industriales',
                    'Administración pública' => 'Administración pública',
                    'Comercio' => 'Comercio',
                    'Construcción' => 'Construcción',
                    'Educación' => 'Educación',
                    'Hostelería' => 'Hostelería',
                    'Inst. financieras, seguros' => 'Inst. financieras, seguros',
                    'Servicios a empresas' => 'Servicios a empresas',
                    'Sanidad' => 'Sanidad',
                    'Servicios personales' => 'Servicios personales',
                    'Serv. recreat. y culturales' => 'Serv. recreat. y culturales',
                    'Serv. soc. y a la comunidad' => 'Serv. soc. y a la comunidad',
                    'Turismo, transporte y comunicaciones' => 'Turismo, transporte y comunicaciones',
                    'Otros' => 'Otros'
                ],
                'placeholder' => 'Selecciona una actividad',
                'attr' => [
                    'class' => 'form-actividad'
                ]
            ])
            ->add('puesto', TextType::class, [
                'label' => 'Puesto de trabajo',
                'required' => true,
                'attr' => [
                    'class' => 'form-puesto'
                ]
            ])
            ->add('tareas', TextType::class, [
                'label' => 'Tareas desempeñadas',
                'required' => true,
                'attr' => [
                    'class' => 'form-tareas'
                ]
            ])
            ->add('fechaInicio', DateType::class, [
                'label' => 'Fecha de inicio (mm-aaaa)',
                'required' => true,
                'format' => 'mm-yyyy',
                'html5' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-datepicker'
                ]
            ])
            ->add('fechaFin', DateType::class, [
                'label' => 'Fecha de finalización (mm-aaaa)',
                'required' => true,
                'format' => 'mm-yyyy',
                'html5' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-datepicker'
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