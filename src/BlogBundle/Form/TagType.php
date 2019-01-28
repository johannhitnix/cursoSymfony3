<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;


class TagType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array("required" => false, "label" => "Nombre", "attr" => array(
                "class" => "form-name form-control"                
            ), 'constraints' => array(new Length(array('min' => 3,'minMessage' => 'debe tener mas de 3 caracteres')), new NotBlank(array('message' => 'el campo no debe ser nulo')))))
            ->add('description', TextareaType::class, array("required" => false, "label" => "Descripcion", "attr" => array(
                "class" => "form-name form-control"                
            ), 'constraints' => array(new Length(array('min' => 6,'minMessage' => 'debe tener mas de 6 caracteres')), new NotBlank(array('message' => 'el campo no debe ser nulo')))))
            ->add('Crear tag', SubmitType::class, array("attr" => array(
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
            'data_class' => 'BlogBundle\Entity\Tag'
        ));
    }
}
