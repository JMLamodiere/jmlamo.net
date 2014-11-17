<?php

namespace Jmlamo\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TwigController extends Controller
{
    /**
     * @Route("/twig")
     * @Template()
     */
    public function indexAction()
    {
        return array(
            // ...
        );
    }

}
