<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class CursoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', TextType::class, array("required" => false, "attr" => array(
                "class" => "form-titulo titulo"                
            ), 'constraints' => array(new Length(array('min' => 3,'minMessage' => 'debe tener mas de 3 caracteres')), new NotBlank(array('message' => 'el campo no debe ser nulo')))))
            ->add('descripcion', TextType::class,array(
                'required' => false,
                'constraints' => array(new Length(array('min' => 3,'minMessage' => 'debe tener mas de 3 caracteres')), new NotBlank(array('message' => 'el campo no debe ser nulo')))))
            ->add('precio', TextType::class,array(
                'required' => false,
                'constraints' => array(new Assert\Type(array(
                    'type' => 'numeric',
                    'message' => 'el precio debe ser numerico'
                )), new Length(array('min' => 3,'minMessage' => 'debe tener mas de 3 caracteres'))) 
            ))
            // ->add('precio', ChoiceType::class, array(
            //     "choices" => array(
            //         "barato" => "barato",
            //         "normal" => "normal",
            //         "caro" => "caro"
            //     )
            // ))
            ->add('Guardar', SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Curso'
        ));
    }
}
