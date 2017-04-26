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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoDoc', ChoiceType::class, [
                'label' => 'Tipo Documento',
                'required' => true,
                'choices'  => [
                    'NIF' => 'NIF',
                    'Tarjeta residencia' => 'Tarjeta residencia',
                    'Pasaporte' => 'Pasaporte',
                    'NIE' => 'NIE'
                ],
                'attr' => [
                    'class' => 'form-tipo-doc'
                ]
            ])
            ->add('password', 'password', [
                'label' => 'Contraseña',
                'required' => true
            ])
            ->add('nombre', TextType::class, [
                'label' => 'Nombre',
                'required' => true,
                'attr' => [
                    'class' => 'form-nombre form-control'
                ]
            ])
            ->add('apellidos', TextType::class, [
                'label' => 'Apellidos',
                'required' => true,
                'attr' => [
                    'class' => 'form-apellidos form-control'
                ]
            ])
            ->add('fechaNac', TextType::class, [
                'label' => 'Fecha nacimiento',
                'required' => true,
                'attr' => [
                    'class' => 'form-fechanac form-control'
                ]
            ])
            ->add('domicilio', TextType::class, [
                'label' => 'Domicilio',
                'required' => true,
                'attr' => [
                    'class' => 'form-domicilio form-control'
                ]
            ])
            ->add('poblacion', TextType::class, [
                'label' => 'Población',
                'required' => true,
                'attr' => [
                    'class' => 'form-poblacion form-control'
                ]
            ])
            ->add('provincia', TextType::class, [
                'label' => 'Provincia',
                'required' => true,
                'attr' => [
                    'class' => 'form-provincia form-control'
                ]
            ])
            ->add('codPostal', TextType::class, [
                'label' => 'Código Postal',
                'required' => true,
                'attr' => [
                    'class' => 'form-cpostal form-control'
                ]
            ])
            ->add('pais', TextType::class, [
                'label' => 'Pais',
                'required' => true,
                'attr' => [
                    'class' => 'form-pais form-control'
                ]
            ])
            ->add('telefono', TextType::class, [
                'label' => 'Telefono 1',
                'required' => true,
                'attr' => [
                    'class' => 'form-tlf1 form-control'
                ]
            ])
            ->add('movil', TextType::class, [
                'label' => 'Telefono 2',
                'required' => false,
                'attr' => [
                    'class' => 'form-tlf2 form-control'
                ]
            ])
            ->add('fax', TextType::class, [
                'label' => 'Fax',
                'required' => false,
                'attr' => [
                    'class' => 'form-fax form-control'
                ]
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'required' => false,
                'attr' => [
                    'class' => 'form-email form-control'
                ]
            ])
            ->add('hijos', ChoiceType::class, [
                'label' => '¿Tiene hijos?',
                'required' => true,
                'choices'  => [
                    'Si' => true,
                    'No' => false
                ],
                'attr' => [
                    'class' => 'form-hijos'
                ]
            ])
            ->add('estadoCivil', ChoiceType::class, [
                'label' => 'Estado civil',
                'required' => true,
                'choices'  => [
                    'Soltero' => 'Soltero',
                    'Casado' => 'Casado',
                    'Otros' => 'Otros'
                ],
                'attr' => [
                    'class' => 'form-ecivil'
                ]
            ])
            ->add('carneConducir', ChoiceType::class, [
                'label' => 'Carné de conducir',
                'required' => false,
                'choices'  => [
                    'Si' => true,
                    'No' => false
                ],
                'attr' => [
                    'class' => 'form-carne'
                ]
            ])
            ->add('claseCarne', TextType::class, [
                'label' => 'Clase carné de conducir',
                'required' => false,
                'attr' => [
                    'class' => 'form-clase-carne form-control'
                ]
            ])
            ->add('vehiculoPropio', ChoiceType::class, [
                'label' => 'Vehículo propio',
                'required' => false,
                'choices'  => [
                    'Si' => true,
                    'No' => false
                ],
                'attr' => [
                    'class' => 'form-vehiculo'
                ]
            ])
            ->add('dispCambioDomicilio', ChoiceType::class, [
                'label' => '* Disponibilidad para cambiar de domicilio',
                'required' => false,
                'choices'  => [
                    'No' => 'No',
                    'Si, dentro de la provincia' => 'Si, dentro de la provincia',
                    'Si, por la comunidad autónoma' => 'Si, por la comunidad autónoma',
                    'Si, en el territorio nacional' => 'Si, en el territorio nacional',
                    'Si, dentro de la Unión Europea' => 'Si, dentro de la Unión Europea',
                    'Si, a cualquier país' => 'Si, a cualquier país'
                ],
                'attr' => [
                    'class' => 'form-disp-domic'
                ]
            ])
            ->add('dispViajar', ChoiceType::class, [
                'label' => '* Disponibilidad para viajar',
                'required' => false,
                'choices'  => [
                    'Si' => true,
                    'No' => false
                ],
                'attr' => [
                    'class' => 'form-disp-viajar'
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
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario'
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_usuario';
    }
}