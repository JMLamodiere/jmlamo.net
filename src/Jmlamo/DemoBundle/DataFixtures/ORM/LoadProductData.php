<?php
namespace Jmlamo\DemoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Jmlamo\DemoBundle\Entity\Product;

class LoadProductData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        //creating a few products with know values, for testing purpose
    
        $product = new Product();
        $product->setName(sprintf('Banana splitter'));
        $product->setPrice(19.99);
        $product->setDescription("The product you'll definitely wanna buy!\nSplits any banana in half within seconds.");
        $em->persist($product);
        
        $product = new Product();
        $product->setName(sprintf('Gluten-free apple'));
        $product->setPrice(2.5);
        $product->setDescription("A gluten-free apple. Comes in different colours and shapes.");
        $em->persist($product);
        
        //completing with random products
        for ($i=1; $i <= 10000; $i++) {
            $product = new Product();
            $product->setName(sprintf('Product #%d (%s)', $i, rand(1, 999999)));
            $product->setPrice(rand(0, 9999999) / 100);
            $product->setDescription("This is the description\nof the product");
            $em->persist($product);
        }
        $em->flush();
    }
}