<?php

namespace Jmlamo\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;

class RoutingController extends Controller
{

    /**
     * @Route("/routing/browser", condition="context.getMethod() in ['GET', 'HEAD'] and request.headers.get('User-Agent') matches '/chrome/i'")
     */
    public function chromeAction(Request $request)
    {
        return $this->render('JmlamoDemoBundle:Routing:browser.html.twig', array('chrome' => true));
    }

    /**
     * @Route("/routing/browser")
     * @Template()
     */
    public function browserAction(Request $request)
    {
        return array('chrome' => false);
    }

    /**
     * @Route("/routing/contact")
     * @Method("GET")
     * @Template()
     */
    public function contactAction()
    {
        $session = $this->get('session');
        $name = $session->get('routingNameValue', 'none');
    
        return array('name' => $name);
    }

    /**
     * @Route("/routing/contact")
     * @Method("POST")
     */
    public function processContactAction(Request $request)
    {
        $session = $this->get('session');
        $session->getFlashBag()->add('notice', 'Form data received');
        $session->set('routingNameValue', substr($request->request->get('name'), 0, 30));
        
        return $this->redirect($this->generateUrl('jmlamo_demo_routing_contact'));
    }

    /**
     * @Route("/routing/{page}", defaults={"page" = 1}, requirements={"page": "\d+"})
     * @Template()
     */
    public function indexAction($page)
    {
        return array('page' => $page);
    }

    /**
     * @Route("/routing/{slug}")
     * @Template()
     */
    public function showAction($slug)
    {
        return array('slug' => $slug);
    }
    
 

}
