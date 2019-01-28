<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use BlogBundle\Entity\Category;
use BlogBundle\Form\CategoryType;

class CategoryController extends Controller
{
    private $session;

    public function __construct(){
        $this->session = new Session();
    }    
    
    public function addAction(Request $request){
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        // lo que viene del formulario se bindea a este objeto
        $form->handleRequest($request);
        
        $status = "";
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();                                
                
                $category->setName($form->get("name")->getData());                       
                $category->setDescription($form->get("description")->getData());

                $em->persist($category);
                $flush = $em->flush();

                if (!$flush) {
                    $status = "la categoria se ha creado correctamente";   
                    $this->session->getFlashBag()->add("tipo", 1);                                 
                } else{
                    $status = "error al crear la categoria";
                }

            } else {
                $status = "error al crear la categoria, formulario no valido";                
            }
            $this->session->getFlashBag()->add("status", $status);            
            return $this->redirectToRoute("blog_index_category");
        } 
        

        return $this->render("BlogBundle:Category:add.html.twig", array(
            "form" => $form->createView()
        ));
    }

    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $category_repo = $em->getRepository("BlogBundle:Category");
        $categories = $category_repo->findAll();

        return $this->render("BlogBundle:Category:index.html.twig", array(
            "categories" => $categories
        ));
    }

    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $category_repo = $em->getRepository("BlogBundle:Category");
        $category = $category_repo->find($id);

        if(count($category->getEntries()) == 0){
            $em->remove($category);
            $flush = $em->flush();
        }

        return $this->redirectToRoute("blog_index_category");

    }

    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $category_repo = $em->getRepository("BlogBundle:Category");
        $category = $category_repo->find($id);

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {                
                
                $category->setName($form->get("name")->getData());                       
                $category->setDescription($form->get("description")->getData());

                $em->persist($category);
                $flush = $em->flush();

                if (!$flush) {
                    $status = "la categoria se ha editado correctamente";   
                    $this->session->getFlashBag()->add("tipo", 1);                                 
                } else{
                    $status = "error al editar la categoria";
                }

            } else {
                $status = "error al editar la categoria, formulario no valido";                
            }
            $this->session->getFlashBag()->add("status", $status);            
            return $this->redirectToRoute("blog_index_category");
        } 

        return $this->render("BlogBundle:Category:edit.html.twig", array(
            "form" => $form->createView()
        ));
    }
}