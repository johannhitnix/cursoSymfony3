<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Curso;
use AppBundle\Form\CursoType;

class PruebasController extends Controller
{
    
    public function indexAction(Request $request,$name,$page)
    {
        // ---EJEMPLO DE GET---
        // var_dump($request->query->get("hola"));
        // die();

        // ---EJEMPLO DE REDIRECCION---
        // return $this->redirect($this->generateURL("homepage"));        
        
        $productos = array(array("producto" => "xbox", "precio" => 1200000, "descripcion" => "consola de microsoft"),
                           array("producto" => "playStation", "precio" => 1400000, "descripcion" => "consola de sony"),
                           array("producto" => "nSwitch", "precio" => 1500000, "descripcion" => "consola de nintendo"),
                           array("producto" => "appleTV", "precio" => 1500000, "descripcion" => "sintoniza los servicios de apple"),
                           array("producto" => "Televisor", "precio" => 1600000, "descripcion" => "televisor 42 pulgadas"));
        
        $frutas = array("manzana" => "golden", "pera" => "peruana");

        $santos = array( array("nombre" => "saga", "signo" => "geminis", "ataque" => "explosion de galaxias"),
                                array("nombre" => "shaka", "signo" => "virgo", "ataque" => "el tesoro del cielo"),
                                array("nombre" => "aioria", "signo" => "leo", "ataque" => "plasma relampago"));

        // ojo con las mayusculas y minusculas porque linux y tambien macOS son case sensitive
        return $this->render('AppBundle:pruebas:index.html.twig', [            
            'texto' => $name." - ".$page,
            'productos' => $productos,
            'frutas' => $frutas,
            'santos' => $santos
        ]);    
    }

    public function createAction(){
        $curso = new Curso();
        $curso->setTitulo("FullStack Developer");
        $curso->setDescripcion("Es un curso completo de FullStack Developer");
        $curso->setPrecio(30000);

        $em = $this->getDoctrine()->getManager();
        // enviar datos al ORM
        $em->persist($curso);
        // volcar los datos a la DB
        $flush = $em->flush();

        // si el $flush esta vacio significa que si se hizo la insercion
        if(!$flush){
            echo "el curso se ha creado correctamente";
        } else{
            echo "el curso no se pudo crear";
        }

        die();
    }

    public function readAction(){
        $em = $this->getDoctrine()->getManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");
        $cursos = $cursos_repo->findAll();

        foreach($cursos as $curso){
            echo $curso->getTitulo() . "<br>";
            echo $curso->getDescripcion() . "<br>";
            echo $curso->getPrecio() . "<br><hr/>";
        }

        die();
    }

    public function updateAction($id, $titulo, $descripcion, $precio){
        $em = $this->getDoctrine()->getManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");

        $curso = $cursos_repo->find($id);
        $curso->setTitulo($titulo);
        $curso->setDescripcion($descripcion);
        $curso->setPrecio($precio);

        $em->persist($curso);
        $flush = $em->flush();

        if(!$flush){
            echo "el curso se ha actualizado correctamente";
        } else{
            echo "el curso NO SE HA ACTUALIZADO";
        }

        die();
    }

    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $cursos_repo = $em->getRepository("AppBundle:Curso");

        $curso = $cursos_repo->find($id);
        $em->remove($curso);
        $flush = $em->flush();

        if(!$flush){
            echo "curso borrado correctamente";
        } else{
            echo "no se ha podido eliminar el curso";
        }

        die();
    }

    public function nativeSqlAction(){
        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();

        $query = "SELECT * FROM cursos";
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);


        $cursos = $stmt->fetchAll();

        foreach($cursos as $curso){
            echo $curso["titulo"] . "<br>";
        }

        die();
    }

    public function formAction(Request $request){
        $curso = new Curso();
        $form = $this->createForm(CursoType::class,$curso);

        $form->handleRequest($request);

        if($form->isValid()){
            $status = "Formulario valido";
            $data = array(
                "titulo" => $form->get("titulo")->getData(),
                "descripcion" => $form->get("descripcion")->getData(),
                "precio" => $form->get("precio")->getData()
            );
        } else{
            $status = null;
            $data = null;
        }

        return $this->render('AppBundle:Pruebas:form.html.twig', array(
            'form' => $form->createView(),
            'status' => $status,
            'data' => $data
        ));
    }
    
}
