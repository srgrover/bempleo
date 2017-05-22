<?php

/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 25/04/17
 * Time: 10:51
 */
namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
                'required' => true,
                'attr' => [
                    'placeholder' => 'ej. Academia Infotel',
                    'class' => 'form-centro'
                ]
            ])
            ->add('titulacion', TextType::class, [
                'label' => 'Titulación',
                'required' => true,
                'attr' => [
                    'placeholder' => 'ej. Curso de contabilidad informatizada',
                    'class' => 'form-titulacion'
                ]
            ])
            ->add('horas', NumberType::class, [
                'label' => 'Horas',
                'required' => true,
                'attr' => [
                    'placeholder' => 'ej. 60',
                    'class' => 'form-especialidad'
                ]
            ])
            ->add('anio', NumberType::class, [
                'label' => 'Año de obtención (aaaa)',
                'required' => true,
                'attr' => [
                    'placeholder' => 'ej. 2006',
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