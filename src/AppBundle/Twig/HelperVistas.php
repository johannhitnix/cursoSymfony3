<?php
    namespace AppBundle\Twig;

    class HelperVistas extends \Twig_Extension{

        public function getFunctions(){
            return array(
                'generateTable' => new \Twig_Function_Method(this, 'generateTable')
            );
        }

        public function getName(){
            return "app_bundle";
        }        
    }