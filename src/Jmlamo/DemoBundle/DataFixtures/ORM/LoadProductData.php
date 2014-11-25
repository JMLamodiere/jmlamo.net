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
        for ($i=1; $i <= 10000; $i++) {
            $product = new Product();
            $product->setName(sprintf('Produit %d %s', $i, rand(1, 999999)));
            $product->setPrice(rand(0, 9999999) / 100);
            $product->setDescription("Ceci est la description de ce produit :\n" . $product->getName());
            $em->persist($product);
        }
        $em->flush();
    }
}