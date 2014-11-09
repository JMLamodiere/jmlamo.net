<?php

namespace Jmlamo\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

class SessionController extends Controller
{
    /**
     * @Route("/session")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        //or $session = $this->get('session');
        
        $counter = $session->get('counter', 0);
        
        if ($counter %2 == 0) {
            $session->getFlashBag()->add(
                'notice',
                sprintf('%d is an even number', $counter)
            );
        }
        
        $session->set('counter', $counter+1);
    
        return array(
            'counter' => $counter,
        );
    }

}
