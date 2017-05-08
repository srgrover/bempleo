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

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoDoc', ChoiceType::class, [
                'label' => '* Tipo Documento',
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
            ->add('numIdenti', TextType::class, [
                'label' => '* Número de identificación',
                'required' => true,
                'attr' => [
                    'class' => 'form-num-identi'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => '* Contraseña',
                'required' => true
            ])
            ->add('nombre', TextType::class, [
                'label' => '* Nombre',
                'required' => true,
                'attr' => [
                    'class' => 'form-nombre'
                ]
            ])
            ->add('apellidos', TextType::class, [
                'label' => '* Apellidos',
                'required' => true,
                'attr' => [
                    'class' => 'form-apellidos'
                ]
            ])
            ->add('sexo', ChoiceType::class, [
                'label' => '* Sexo',
                'required' => true,
                'choices'  => [
                    'Hombre' => 'H',
                    'Mujer' => 'M'
                ],
                'attr' => [
                    'class' => 'form-sexo'
                ]
            ])
            ->add('fechaNac', BirthdayType::class, [
                'label' => '* Fecha nacimiento',
                'required' => true,
                'attr' => [
                    'class' => 'form-fechanac'
                ]
            ])
            ->add('domicilio', TextType::class, [
                'label' => '* Domicilio',
                'required' => true,
                'attr' => [
                    'class' => 'form-domicilio'
                ]
            ])
            ->add('poblacion', TextType::class, [
                'label' => '* Población',
                'required' => true,
                'attr' => [
                    'class' => 'form-poblacion'
                ]
            ])
            ->add('provincia', TextType::class, [
                'label' => '* Provincia',
                'required' => true,
                'attr' => [
                    'class' => 'form-provincia'
                ]
            ])
            ->add('codPostal', TextType::class, [
                'label' => '* Código Postal',
                'required' => true,
                'attr' => [
                    'class' => 'form-cpostal'
                ]
            ])
            ->add('pais', TextType::class, [
                'label' => '* Pais',
                'required' => true,
                'attr' => [
                    'class' => 'form-pais'
                ]
            ])
            ->add('telefono', TextType::class, [
                'label' => '* Telefono 1',
                'required' => true,
                'attr' => [
                    'class' => 'form-tlf1'
                ]
            ])
            ->add('movil', TextType::class, [
                'label' => 'Telefono 2',
                'required' => false,
                'attr' => [
                    'class' => 'form-tlf2'
                ]
            ])
            ->add('fax', TextType::class, [
                'label' => 'Fax',
                'required' => false,
                'attr' => [
                    'class' => 'form-fax'
                ]
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'required' => false,
                'attr' => [
                    'class' => 'form-email'
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
                'required' => true,
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
                    'class' => 'form-clase-carne'
                ]
            ])
            ->add('vehiculoPropio', ChoiceType::class, [
                'label' => 'Vehículo propio',
                'required' => true,
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
                'required' => true,
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
                'required' => true,
                'choices'  => [
                    'Si' => true,
                    'No' => false
                ],
                'attr' => [
                    'class' => 'form-disp-viajar'
                ]
            ])
            ->add('situLaboral', ChoiceType::class, [
                'label' => '* Situación laboral',
                'required' => true,
                'choices'  => [
                    'Desempleado menos de un año' => 'Desempleado menos de un año',
                    'Desempleado mas de un año' => 'Desempleado mas de un año',
                    'Ocupado' => 'Ocupado',
                    'Demandante de 1º empleo' => 'Demandante de 1º empleo',
                    'Mejora de empleo' => 'Mejora de empleo'
                ],
                'attr' => [
                    'class' => 'form-sit-lab'
                ]
            ])
            ->add('horarioTrabajo', ChoiceType::class, [
                'label' => '* Horario de trabajo',
                'required' => true,
                'choices'  => [
                    'Completo' => 'Completo',
                    'Parcial' => 'Parcial',
                    'Tarde' => 'Tarde',
                    'Mañana' => 'Mañana',
                    'Indiferente' => 'Indiferente'
                ],
                'attr' => [
                    'class' => 'form-horario-trabajo'
                ]
            ])
            ->add('prefOcupacion', TextAreaType::class, [
                'label' => '* Preferencias de ocupación',
                'required' => true,
                'attr' => [
                    'class' => 'form-pref-ocupacion'
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