<?php
namespace Jmlamo\DemoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Jmlamo\DemoBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $category = new Category();
        $category->setName('Random products');
        $category->setId(1);
        $em->persist($category);
        
        //disable auto-increment
        $metadata = $em->getClassMetaData(get_class($category));
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        //first flush using this metadata
        $em->flush();
        
        //re-enable auto-increment
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_AUTO);
    
        for ($i=2; $i <= 6; $i++) {
            $category = new Category();
            $category->setName(sprintf('Category %d', $i));

            $em->persist($category);
            $this->addReference('category' . $i, $category);
        }
        $em->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}