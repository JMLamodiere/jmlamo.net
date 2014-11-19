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
        return array();
    }
    
    /**
     * @Route("/twig/for")
     * @Template()
     */
    public function forAction()
    {
        $begin = new \DateTime('now');
        //now + 4 days
        $end = clone $begin;
        $end->add(new \DateInterval('P4D'));
        
        //4 days coming, including today
        $period = new \DatePeriod($begin, new \DateInterval('P1D'), $end);
        
        return array(
            'period' => $period,
        );
    }
    
    /**
     * @Route("/twig/embedding")
     * @Template()
     */
    public function embeddingAction()
    {
        return array();
    }
    
    /**
     * @Template()
     */
    public function lastDaysAction($max = 3)
    {
        $end = new \DateTime('now');
        $begin = clone $end;
        $begin->sub(new \DateInterval('P' . $max . 'D'));
        
        //4 days coming, including today
        $period = new \DatePeriod($begin, new \DateInterval('P1D'), $end);
        
        return array(
            'period' => $period,
        );
    }    

}
