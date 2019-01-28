<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;


class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('name', TextType::class, array("required" => false, "label" => "Nombres", "attr" => array(
                "class" => "form-name form-control"                
            ), 'constraints' => array(new Length(array('min' => 3,'minMessage' => 'debe tener mas de 3 caracteres')), new NotBlank(array('message' => 'el campo no debe ser nulo')))))
            ->add('surname', TextType::class, array("required" => false, "label" => "Apellidos", "attr" => array(
                "class" => "form-surname form-control"                
            ), 'constraints' => array(new Length(array('min' => 3,'minMessage' => 'debe tener mas de 3 caracteres')), new NotBlank(array('message' => 'el campo no debe ser nulo')))))
            ->add('email', EmailType::class, array("required" => false, "attr" => array(
                "class" => "form-email form-control"                
            ), 'constraints' => array(new Length(array('min' => 3,'minMessage' => 'debe tener mas de 3 caracteres')), new NotBlank(array('message' => 'el campo no debe ser nulo')))))
            ->add('password', PasswordType::class, array("required" => false, "label" => "Contraseña", "attr" => array(
                "class" => "form-password form-control"                
            ), 'constraints' => array(new Length(array('min' => 3,'minMessage' => 'debe tener mas de 3 caracteres')), new NotBlank(array('message' => 'el campo no debe ser nulo')))))
            ->add('SignIn', SubmitType::class, array("attr" => array(
                "class" => "form-submit btn btn-primary mt-3"
            )))            
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\User'
        ));
    }
}
