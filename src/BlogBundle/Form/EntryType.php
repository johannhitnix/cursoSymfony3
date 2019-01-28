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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EntryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array("required" => false, "label" => "Titulo:", "attr" => array(
                "class" => "form-name form-control"                
            ), 'constraints' => array(new Length(array('min' => 3,'minMessage' => 'debe tener mas de 3 caracteres')), new NotBlank(array('message' => 'el campo no debe ser nulo')))))
            ->add('content', TextType::class, array("required" => false, "label" => "Contenido:", "attr" => array(
                "class" => "form-name form-control"                
            ), 'constraints' => array(new Length(array('min' => 3,'minMessage' => 'debe tener mas de 3 caracteres')), new NotBlank
            (array('message' => 'el campo no debe ser nulo')))))

            // CHOICES
            ->add('status', ChoiceType::class, array("required" => false, "label" => "Estado:", 
                "choices" => array(
                    "Publico" => "public",
                    "Privado" => "private"
                ),
                "attr" => array(
                "class" => "form-name form-control"                
            ), 'constraints' => array(new NotBlank(array('message' => 'el campo no debe ser nulo')))))

            ->add('image', FileType::class, array("required" => false, "label" => "Imagen:", "attr" => array(
                "class" => "form-name form-control"                
            ), 'constraints' => array(new Length(array('min' => 3,'minMessage' => 'debe tener mas de 3 caracteres')), new NotBlank(array('message' => 'el campo no debe ser nulo')))))

            // ->add('user', TextType::class, array("required" => false, "label" => "Nombre", "attr" => array(
            //     "class" => "form-name form-control"                
            // ), 'constraints' => array(new Length(array('min' => 3,'minMessage' => 'debe tener mas de 3 caracteres')), new NotBlank(array('message' => 'el campo no debe ser nulo')))))

            ->add('category', EntityType::class, array(
                "required" => false, 
                "label" => "Categorias:", 
                "class" => 'BlogBundle:Category',
                "attr" => array(
                    "class" => "form-name form-control"                
            )))
            
            ->add('tags', TextType::class, array("required" => false, "mapped" => false, "label" => "Etiquetas:", "attr" => array(
                "class" => "form-name form-control"                
            ), 'constraints' => array(new Length(array('min' => 3,'minMessage' => 'debe tener mas de 3 caracteres')), new NotBlank(array('message' => 'el campo no debe ser nulo')))))
            ->add('Guardar', SubmitType::class, array("attr" => array(
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
            'data_class' => 'BlogBundle\Entity\Entry'
        ));
    }
}
