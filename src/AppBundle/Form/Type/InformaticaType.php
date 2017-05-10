<?php

/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 25/04/17
 * Time: 10:51
 */
namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformaticaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('campo', ChoiceType::class, [
                'label' => 'Campo de la informática',
                'required' => false,
                'choices'  => [
                    'Ofimática' => 'Ofimática',
                    'Programación' => 'Programación',
                    'Administración de sistemas' => 'Administración de sistemas',
                    'Aplicaciones temáticas' => 'Aplicaciones temáticas'
                ],
                'placeholder' => 'Selecciona un campo',
                'attr' => [
                    'class' => 'form-campo_inf'
                ]
            ])
            ->add('nivel', ChoiceType::class, [
                'label' => 'Indicar nivel',
                'required' => false,
                'choices'  => [
                    'Usuario' => 'Usuario',
                    'Avanzado' => 'Avanzado',
                    'Profesional' => 'Profesional'
                ],
                'placeholder' => 'Selecciona un nivel',
                'attr' => [
                    'class' => 'form-nivel'
                ]
            ])
            ->add('programasManeja', TextareaType::class, [
                'label' => 'Escriba una lista de programas que domina',
                'required' => false,
                'placeholder' => 'Microsoft Word, Adobe Photoshop, etc...',
                'attr' => [
                    'class' => 'form-programas-maneja'
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
        return 'informatica';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Informatica'
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_informatica';
    }
}