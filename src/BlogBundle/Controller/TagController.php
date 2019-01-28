<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use BlogBundle\Entity\Tag;
use BlogBundle\Form\TagType;

class TagController extends Controller
{
    private $session;

    public function __construct(){
        $this->session = new Session();
    }    
    
    public function addAction(Request $request){
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        // lo que viene del formulario se bindea a este objeto
        $form->handleRequest($request);
        
        $status = "";
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();                                
                
                $tag->setName($form->get("name")->getData());                       
                $tag->setDescription($form->get("description")->getData());

                $em->persist($tag);
                $flush = $em->flush();

                if (!$flush) {
                    $status = "la etiqueta se ha creado correctamente";   
                    $this->session->getFlashBag()->add("tipo", 1);                                 
                } else{
                    $status = "error al crear la etiqueta";
                }

            } else {
                $status = "error al crear la etiqueta, formulario no valido";                
            }
            $this->session->getFlashBag()->add("status", $status);            
            return $this->redirectToRoute("blog_index_tag");
        } 
        

        return $this->render("BlogBundle:Tag:add.html.twig", array(
            "form" => $form->createView()
        ));
    }

    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $tag_repo = $em->getRepository("BlogBundle:Tag");
        $tags = $tag_repo->findAll();

        return $this->render("BlogBundle:Tag:index.html.twig", array(
            "tags" => $tags
        ));
    }

    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $tag_repo = $em->getRepository("BlogBundle:Tag");
        $tag = $tag_repo->find($id);

        if(count($tag->getEntryTag()) == 0){
            $em->remove($tag);
            $flush = $em->flush();
        }

        return $this->redirectToRoute("blog_index_tag");

    }
}