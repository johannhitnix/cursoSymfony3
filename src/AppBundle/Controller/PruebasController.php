<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
    
}
