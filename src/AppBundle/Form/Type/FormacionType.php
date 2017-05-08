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
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
                'required' => false,
                'attr' => [
                    'class' => 'form-centro'
                ]
            ])
            ->add('titulacion', TextType::class, [
                'label' => 'Titulación',
                'required' => false,
                'attr' => [
                    'class' => 'form-titulacion'
                ]
            ])
            ->add('especialidad', TextType::class, [
                'label' => 'Especialidad',
                'required' => false,
                'attr' => [
                    'class' => 'form-especialidad'
                ]
            ])
            ->add('obtencion', BirthdayType::class, [
                'label' => 'Obtención',
                'required' => false,
                'widget' => 'single_text',
                // this is actually the default format for single_text
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