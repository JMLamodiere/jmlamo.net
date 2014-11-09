<?php

namespace Jmlamo\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class HelloController extends Controller
{
    /**
     * url "/hello/world" matches worldAction AND indexAction, but the first one is called
     * @Route("/hello/world")
     */
    public function worldAction()
    {
        return new Response('<html><body>Hello world, sending new Response("html code")</body></html>');
    }
    
    /**
     * @Route("/hello/wizard")
     */
    public function wizardAction()
    {
        $response = $this->forward('JmlamoDemoBundle:Hello:index', array('firstname' => 'Harry', 'lastname' => 'Poster'));
        
        return $response;
    }
    
    /**
     * Ex : "/hello/manual-rendering?nameInQueryString=Sanchez"
     * @Route("/hello/manual-rendering")
     */
    public function manualrenderingAction(Request $request)
    {
        //or $request = $this->get('request');
    
        $content = $this->renderView('JmlamoDemoBundle:Hello:index.html.twig', array(
            'firstname' => 'Manual',
            'lastname' => $request->get('nameInQueryString', 'Anonymous'),
        ));
        
        return new Response($content);
        
        //or return $this->render(...
    }
    
    /**
     * @Route("/hello/json")
     */
    public function jsonredirAction($name = null)
    {
        return $this->redirect($this->generateUrl('jmlamo_demo_hello_json', array('name' => 'John')), 301);
    }    
    
    /**
     * @Route("/hello/json/{name}.json")
     */
    public function jsonAction(Request $request, $name)
    {
        $data = array(
            'name' => $name,
        );
        
        //adding all query string datas
        //$data += $request->query->all();
        
        $response = new JsonResponse($data, Response::HTTP_OK);
        
        // $response = new Response(json_encode($data), Response::HTTP_OK);
        // $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }     
    
    /**
     * @Route("/hello/god")
     */
    public function godAction()
    {
        throw $this->createNotFoundException('God does not exist (in this bundle...)');
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
