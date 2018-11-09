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
        
        $productos = array(array("producto" => "xbox", "precio" => 1200000),
                            array("producto" => "playStation", "precio" => 1400000),
                            array("producto" => "switch", "precio" => 1500000),
                            array("producto" => "appleTV", "precio" => 1500000),
                            array("producto" => "Televisor", "precio" => 1600000));
        
        $frutas = array("manzana" => "golden", "pera" => "peruana");

        // ojo con las mayusculas y minusculas porque linux y tambien macOS son case sensitive
        return $this->render('AppBundle:pruebas:index.html.twig', [            
            'texto' => $name." - ".$page,
            'productos' => $productos,
            'frutas' => $frutas
        ]);    
    }
    
}
