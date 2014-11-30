<?php
namespace Jmlamo\DemoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Jmlamo\DemoBundle\Entity\Product;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        //creating a few products with know values, for testing purpose
    
        $product = new Product();
        $product->setId(1);
        $product->setName(sprintf('Banana splitter'));
        $product->setPrice(19.99);
        $product->setDescription("The product you'll definitely wanna buy!\nSplits any banana in half within seconds.");
        $em->persist($product);
        
        $product = new Product();
        $product->setId(2);
        $product->setName(sprintf('Gluten-free apple'));
        $product->setPrice(2.5);
        $product->setDescription("A gluten-free apple. Comes in different colours and shapes.");
        $em->persist($product);
        
         //disable auto-increment
        $metadata = $em->getClassMetaData(get_class($product));
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        //first flush using this metadata
        $em->flush();
        
        //re-enable auto-increment
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_AUTO);
        
        //completing with random products
        for ($i=1; $i <= 5000; $i++) {
            $product = new Product();
            $product->setName(sprintf('Product #%d (%s)', $i, rand(1, 999999)));
            $product->setPrice(rand(0, 9999999) / 100);
            $product->setDescription("This is the description\nof the product");
            
            //we don't always add a category
            if (rand(0, 10) >= 2) {
                $category_id = rand(2, 6);
                $category = $this->getReference('category' . $category_id);
                $product->setCategory($category);
            }
            
            $em->persist($product);
        }
        $em->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }    
}