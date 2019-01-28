<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use BlogBundle\Entity\Entry;
use BlogBundle\Form\EntryType;

class EntryController extends Controller
{
    private $session;

    public function __construct(){
        $this->session = new Session();
    }    

    public function indexAction(){
        $em = $this->getDoctrine()->getManager();    
        $entry_repo = $em->getRepository("BlogBundle:Entry");
        $category_repo = $em->getRepository("BlogBundle:Category");

        $entries = $entry_repo->findAll();
        $categories = $category_repo->findAll();

        return $this->render("BlogBundle:Entry:index.html.twig", array(
            "entries" => $entries,
            "categories" => $categories
        ));
    }
    
    public function addAction(Request $request){
        $entry = new Entry();
        $form = $this->createForm(EntryType::class, $entry);
        // lo que viene del formulario se bindea a este objeto
        $form->handleRequest($request);
        
        $status = "";
         
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();    
                $entry_repo = $em->getRepository("BlogBundle:Entry");
                $category_repo = $em->getRepository("BlogBundle:Category");                            
                
                $entry->setTitle($form->get("title")->getData());
                $entry->setContent($form->get("content")->getData());
                $entry->setStatus($form->get("status")->getData());                

                // upload file
                $file = $form["image"]->getData();
                $ext = $file->guessExtension();
                // "usamos el fichero para asignarselo a una entrada"
                $file_name = time() . "." . $ext;
                $file->move("uploads", $file_name);
                $entry->setImage($file_name);

                $category = $category_repo->find($form->get("category")->getData());
                $entry->setCategory($category);
                
                // saca de la sesion actual el usuario identificado
                $user = $this->getUser();                
                $entry->setUser($user);

                $em->persist($entry);
                $flush = $em->flush();

                $entry_repo->saveEntryTags(
                    $form->get("tags")->getData(),
                    $form->get("title")->getData(),
                    $category,
                    $user
                );

                if (!$flush) {
                    $status = "la entrada se ha creado correctamente";   
                    $this->session->getFlashBag()->add("tipo", 1);                                 
                } else{
                    $status = "error al crear la entrada";
                }

            } else {
                $status = "error al crear la entrada, formulario no valido";                
            }
            $this->session->getFlashBag()->add("status", $status);            
            return $this->redirectToRoute("blog_index_entry");
        }         

        return $this->render("BlogBundle:Entry:add.html.twig", array(
            "form" => $form->createView()
        ));        
    }
    
}

