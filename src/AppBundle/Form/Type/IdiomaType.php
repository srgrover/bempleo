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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IdiomaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idioma', ChoiceType::class, [
                'label' => 'Idioma',
                'required' => false,
                'choices'  => [
                    'Alemán' => 'Alemán',
                    'Árabe' => 'Árabe',
                    'Catalán' => 'Catalán',
                    'Chino' => 'Chino',
                    'Danés' => 'Danés',
                    'Español' => 'Español',
                    'Euskera' => 'Euskera',
                    'Finés' => 'Finés',
                    'Francés' => 'Francés',
                    'Gallego' => 'Gallego',
                    'Griego' => 'Griego',
                    'Inglés' => 'Inglés',
                    'Italiano' => 'Italiano',
                    'Japonés' => 'Japonés',
                    'Polaco' => 'Polaco',
                    'Portugués' => 'Portugués',
                    'Rumano' => 'Rumano',
                    'Ruso' => 'Ruso',
                    'Sueco' => 'Sueco',
                    'Otro' => 'Otro',
                ],
                'placeholder' => 'Selecciona un Idioma',
                'attr' => [
                    'class' => 'form-idioma'
                ]
            ])
            ->add('traduce', ChoiceType::class, [
                'label' => 'Nivel de traducción',
                'required' => false,
                'choices'  => [
                    'Básico' => 'Básico',
                    'Intermedio' => 'Intermedio',
                    'Alto' => 'Alto'
                ],
                'placeholder' => 'Selecciona un nivel',
                'attr' => [
                    'class' => 'form-tradauce'
                ]
            ])
            ->add('habla', ChoiceType::class, [
                'label' => 'Nivel hablado',
                'required' => false,
                'choices'  => [
                    'Básico' => 'Básico',
                    'Intermedio' => 'Intermedio',
                    'Alto' => 'Alto'
                ],
                'placeholder' => 'Selecciona un nivel',
                'attr' => [
                    'class' => 'form-habla'
                ]
            ])
            ->add('escribe', ChoiceType::class, [
                'label' => 'Nivel escrito',
                'required' => false,
                'choices'  => [
                    'Básico' => 'Básico',
                    'Intermedio' => 'Intermedio',
                    'Alto' => 'Alto'
                ],
                'placeholder' => 'Selecciona un nivel',
                'attr' => [
                    'class' => 'form-escribe'
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
        return 'idioma';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Idioma'
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_idioma';
    }
}