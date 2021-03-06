<?php
namespace AppBundle\Form\Type;

use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class PassType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('actual', PasswordType::class, [
                'label' => 'Contraseña actual',
                'mapped' => false,
                'required' => 'required',
                'constraints' => [
                    new UserPassword()
                ]
            ])
            ->add('nueva', RepeatedType::class, [
                'mapped' => false,
                'required' => 'required',
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Nueva contraseña'
                ],
                'second_options' =>[
                    'label' => 'Repite la nueva contraseña'
                ],
                'constraints' => [
                    new Length([
                        'min' => 8
                    ])
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
            'translation_domain' => 'usuario'
        ]);
    }
}