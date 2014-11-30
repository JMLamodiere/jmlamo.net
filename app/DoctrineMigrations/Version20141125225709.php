<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Jmlamo\DemoBundle\Entity\Product;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141125225709 extends AbstractMigration implements ContainerAwareInterface
{
    /** @var ContainerInterface  */
    private $container;
    
    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
    
    public function postUp(Schema $schema)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        
        $product = new Product();
        $product->setName('My first product');
        $product->setPrice('19.99');
        $product->setDescription('First product, added by migraton 20141125225709');
        
        $em->persist($product);
        
        //Error : SQLSTATE[42S22]: Column not found: 1054 Unknown column 'category_id' in 'field list'
        //The php Product class has a new column "category_id" wich didn't existed at the time of this migration
        //@TODO : find a way to handle this problem
        //$em->flush();
    }
}
