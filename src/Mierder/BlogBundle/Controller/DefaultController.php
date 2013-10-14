<?php

namespace Mierder\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
    
    
    
    /**
     * @Route("/info")
     * @Template()
     */
    public function infoPageAction()
    {
        return array('postTitle' => 'titulo del post', 'postBody'=> 'Este es el cuerpo del delito!');
    }
}
