<?php

namespace Jmlamo\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends Controller
{
    /**
     * url "/hello/world" matches worldAction AND indexAction, but the first one is called
     * @Route("/hello/world")
     */
    public function worldAction(Request $request)
    {
        return new Response('<html><body>Hello world, sending new Response("html code")</body></html>');
    }

    /**
     * @Route("/hello/{firstname}/{lastname}")
     * @Template()
     */
    public function indexAction($firstname = null, $lastname = 'Doe')
    {
        //if no firstname, redirect 301 with au firstname
        if (empty($firstname)) {
            return $this->redirect($this->generateUrl('jmlamo_demo_hello_index', array('firstname' => 'John')), 301);
        }
    
    
        return array(
            'firstname' => $firstname,
            'lastname' => $lastname,
        );
    }
}
