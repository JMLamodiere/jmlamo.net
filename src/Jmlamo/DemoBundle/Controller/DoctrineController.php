<?php

namespace Jmlamo\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Jmlamo\DemoBundle\Entity\Product;

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
    
    /**
     * @Route("/doctrine/create")
     */
    public function createAction()
    {
        //creating new product with random values
        $product = new Product();
        $product->setName('product ' . rand(1000, 9999));
        $product->setPrice(rand(0, 999999) / 100);
        $product->setDescription('lorem ipsum');

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
        
        $session = $this->get('session');
        $session->getFlashBag()->add('notice', 'Product created : ' . $product->getName());
        
        return $this->redirect($this->generateUrl('jmlamo_demo_doctrine_index'));
    }
    
    /**
     * @Route("/doctrine/update/{id}")
     */
    public function updateAction(Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $product->setName('Edited name, ' . date('H:i:s'));
        $em->flush();
        
        $session = $this->get('session');
        $session->getFlashBag()->add('notice', 'Product edited : ' . $product->getName());
        
        return $this->redirect($this->generateUrl('jmlamo_demo_doctrine_findbyordered'));
    }
    
    /**
     * @Route("/doctrine/show/{id}.html")
     * @Template()
     */
    public function showAction($id)
    {
        $product = $this->getDoctrine()
            ->getRepository('JmlamoDemoBundle:Product')
            ->find($id);
        
        //manual 404 error if no product found
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        return array('product' => $product);
    }
    
    /**
     * @Route("/doctrine/autoshow/{id}.html")
     */
    public function autoshowAction(Product $product)
    {
        //If no product found, 404 error is automatic
        return $this->render('JmlamoDemoBundle:Doctrine:show.html.twig',  array('product' => $product));
    }
    
    /**
     * @Route("/doctrine/find-one-by-name/{name}.html")
     */
    public function findOneByNameAction($name)
    {
        $repository = $this->get('doctrine')
            ->getRepository('JmlamoDemoBundle:Product');
        
        $product = $repository->findOneByName($name);
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for this name '
            );
        }
        
        //Forwarding to autoshowAction, passing the product as parameter
        return $this->forward('JmlamoDemoBundle:Doctrine:autoshow', array('product' => $product));
    }
    
    /**
     * @Route("/doctrine/find-by-ordered/")
     * @Template()
     */
    public function findByOrderedAction()
    {
        $repository = $this->get('doctrine')
            ->getRepository('JmlamoDemoBundle:Product');
        
        $products = $repository->findBy(
            //where conditions
            array('description' => 'lorem ipsum'),
            
            //order by
            array('price' => 'ASC')
        );
        
        return array('products' => $products);
    }    

}
