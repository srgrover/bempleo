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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FcomplementariaType extends AbstractType
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
            ->add('horas', TextType::class, [
                'label' => 'Horas',
                'required' => false,
                'attr' => [
                    'class' => 'form-especialidad'
                ]
            ])
            ->add('anio', BirthdayType::class, [
                'label' => 'Año de obtención (aaaa)',
                'required' => false,
                'widget' => 'single_text',
                'format' => 'yyyy',
                'placeholder' => [
                    'year' => 'ej. 2010',
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
        return 'fcomplementaria';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Fcomplementaria'
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_fcomplementaria';
    }
}