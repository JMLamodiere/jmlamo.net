<?php

namespace Jmlamo\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RoutingController extends Controller
{

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
