<?php

namespace Jmlamo\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\GroupSequenceProviderInterface;

/**
 * Author
 *
 * @ORM\Table(name="author")
 * @ORM\Entity
 * @Assert\GroupSequence({"Author", "Strict"})
 */
class Author implements GroupSequenceProviderInterface
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
     * @Assert\NotBlank(groups={"Default", "registration"})
     * @Assert\Length(min = "2", groups={"Default", "registration"})
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=20, nullable=true)
     * @Assert\Choice(
     *     choices = { "male", "female" },
     *     message = "Choose a valid gender.",
     *     groups={"Strict"}
     * )
     */
    private $gender;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(groups={"registration"})
     */
    private $password;    

    /**
     * @var string
     *
     * @ORM\Column(type="boolean")
     */
    private $premium = false;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=34, nullable=true)
     * @Assert\NotBlank(
     *     groups = {"Premium"},
     *     message = "IBAN required for premium users"
     * )
     * @Assert\Iban
     */
    private $iban;

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
     * @Assert\True(message = "The password cannot match your name", groups={"Default", "registration"})
     */
    public function isPasswordLegal()
    {
        return $this->name != $this->password;
    }    

    /**
     * Set premium
     *
     * @param boolean $premium
     * @return Author
     */
    public function setPremium($premium)
    {
        $this->premium = $premium;

        return $this;
    }

    /**
     * Get premium
     *
     * @return boolean 
     */
    public function getPremium()
    {
        return $this->premium;
    }
    
    /**
     * Is premium
     *
     * @return boolean
     */
    public function isPremium()
    {
        return (boolean) $this->premium;
    }    

    /**
     * Set iban
     *
     * @param string $iban
     * @return Author
     */
    public function setIban($iban)
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * Get iban
     *
     * @return string 
     */
    public function getIban()
    {
        return $this->iban;
    }
    
    /**
     * @return array
     */
    public function getGroupSequence()
    {
        $groups = array('Author');
        
        if ($this->isPremium()) {
            $groups[] = 'Premium';
        }
        
        return $groups;
    }

}
