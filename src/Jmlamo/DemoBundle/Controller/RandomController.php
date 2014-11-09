<?php

namespace Jmlamo\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RandomController extends Controller
{
    /**
     * @Route("/random/{limit}")
     * @Template()
     */
    public function indexAction($limit = 100)
    {
        $randomNumber = rand(1, $limit);
        return array(
            'limit' => $limit,
            'randomNumber' => $randomNumber
        );
    }

}
