<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use BlogBundle\Entity\User;
use BlogBundle\Form\UserType;

class UserController extends Controller
{
    private $session;

    public function __construct(){
        $this->session = new Session();
    }

    public function loginAction(Request $request){
        $authenticationUtils = $this->get("security.authentication_utils");
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();        
        
        return $this->render("BlogBundle:User:login.html.twig", array(
            "error" => $error,
            "last_username" => $lastUsername            
        ));
    }    

    public function signinAction(Request $request){
        $user = new User();
        $form = $this->createForm(UserType::class,$user);

        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $user_repo = $em->getRepository("BlogBundle:User");
                $user = $user_repo->findOneBy(array("email" => $form->get("email")->getData()));
                if(count($user) == 0){
                    $user = new User();
                    $user->setName($form->get("name")->getData());
                    $user->setSurname($form->get("surname")->getData());
                    $user->setEmail($form->get("email")->getData());
                    

                    // ---CIFRADO BCRYPT---

                    // se llama el servicio de encripcion contraseña
                    $factory = $this->get("security.encoder_factory");
                    // el encoder va vinculado a la entidad                    
                    $encoder = $factory->getEncoder($user);
                    $password = $encoder->encodePassword($form->get("password")->getData(), $user->getSalt());

                    // ---FIN BCRYPT---

                    $user->setPassword($password);
                    $user->setRole("ROLE_USER");
                    $user->setImagen(null);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $flush = $em->flush();

                    if (!$flush) {
                        $status = "Registro exitoso";       
                        $tipo = 1;                     
                        $this->session->getFlashBag()->add("tipo", $tipo);
                    } else {
                        $status = "El registro no es correcto";                              
                    }                    
                } else{
                    $status = "el usuario ya existe!!!";                    
                }
            } else{
                $status = "El registro no es correcto";                            
            }
            // sesion flashbag 
            $this->session->getFlashBag()->add("status", $status);            
        }

        return $this->render("BlogBundle:User:signin.html.twig", array(
            "form" => $form->createView()
        ));
    }
}