<?php

namespace Jmlamo\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DoctrineController extends Controller
{
    /**
     * @Route("/doctrine")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

}
