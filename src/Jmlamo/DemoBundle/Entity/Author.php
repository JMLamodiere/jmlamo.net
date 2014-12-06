<?php

namespace Jmlamo\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Author
 *
 * @ORM\Table(name="author")
 * @ORM\Entity
 */
class Author
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(min = "2")
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=20, nullable=true)
     * @Assert\Choice(
     *     choices = { "male", "female" },
     *     message = "Choose a valid gender."
     * )
     */
    private $gender;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $password;    


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Author
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Author
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Author
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @Assert\True(message = "The password cannot match your name")
     */
    public function isPasswordLegal()
    {
        return $this->name != $this->password;
    }    
}
