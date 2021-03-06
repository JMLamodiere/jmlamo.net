<?php

namespace Jmlamo\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Email;
use Jmlamo\DemoBundle\Entity\Author;
use Jmlamo\DemoBundle\Validator\Constraints\Bic;

class ValidationController extends Controller
{
    /**
     * @Route("/validation")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/validation/set-name/{name}")
     */
    public function setNameAction(Request $request, $name = null)
    {
        $validator = $this->get('validator');
        $session = $request->getSession();
        
        $author = new Author();
        $author->setName($name);
        
        $errors = $validator->validate($author);
        
        if (count($errors) > 0) {
            $session->getFlashBag()->add(
                'notice',
                // @see __toString()
                (string) $errors
            );
            
        } else {
            $session->getFlashBag()->add(
                'notice',
                sprintf('%s is valid !', $author->getName())
            );
        }
        
        return $this->redirect($this->generateUrl('jmlamo_demo_validation_index'));
    }
    
    /**
     * @Route("/validation/set-gender/{gender}")
     */
    public function setGenderAction(Request $request, $gender = null)
    {
        $validator = $this->get('validator');
        $session = $request->getSession();
        
        $author = new Author();
        $author->setName('Gomez');
        
        $author->setGender($gender);
        
        $errors = $validator->validate($author);
        
        if (count($errors) > 0) {
            $session->getFlashBag()->add(
                'notice',
                // @see __toString()
                (string) $errors
            );
            
        } else {
            $gender = $author->getGender();
            if (strlen($gender) > 0) {
                $session->getFlashBag()->add(
                    'notice',
                    sprintf('%s is valid !', $gender)
                );
            } else {
                $session->getFlashBag()->add(
                    'notice',
                    'Ok, gender is not required !'
                );
            }
        }
        
        return $this->redirect($this->generateUrl('jmlamo_demo_validation_index'));
    }
    
    /**
     * @Route("/validation/set-password/{password}")
     */
    public function setPasswordAction(Request $request, $password = null)
    {
        $validator = $this->get('validator');
        $session = $request->getSession();
        
        $author = new Author();
        $author->setName('Jude');
        
        $author->setPassword($password);
        
        $errors = $validator->validate($author);
        
        if (count($errors) > 0) {
            $session->getFlashBag()->add(
                'notice',
                // @see __toString()
                (string) $errors
            );
            
        } else {
            $password = $author->getPassword();
            if (strlen($password) > 0) {
                $session->getFlashBag()->add(
                    'notice',
                    'Password is legal !'
                );
            } else {
                $session->getFlashBag()->add(
                    'notice',
                    'Ok, password is not required !'
                );
            }
        }
        
        return $this->redirect($this->generateUrl('jmlamo_demo_validation_index'));
    }
    
    /**
     * @Route("/validation/set-registration-password/{password}")
     */
    public function setRegistrationPasswordAction(Request $request, $password = null)
    {
        $validator = $this->get('validator');
        $session = $request->getSession();
        
        $author = new Author();
        $author->setName('Jude');
        
        $author->setPassword($password);
        
        //specific constraints during registration
        $errors = $validator->validate($author, null, array('registration'));
        
        if (count($errors) > 0) {
            $session->getFlashBag()->add(
                'notice',
                // @see __toString()
                (string) $errors
            );
            
        } else {
            $session->getFlashBag()->add(
                'notice',
                'Password is legal !'
            );
        }
        
        return $this->redirect($this->generateUrl('jmlamo_demo_validation_index'));
    }
    
    /**
     * @Route("/validation/set-name-and-gender/{name}/{gender}")
     */
    public function setNameAndGenderAction(Request $request, $name, $gender)
    {
        $validator = $this->get('validator');
        $session = $request->getSession();
        
        $author = new Author();
        $author->setName($name);
        $author->setGender($gender);
        
        $errors = $validator->validate($author);
        
        if (count($errors) > 0) {
            $session->getFlashBag()->add(
                'notice',
                // @see __toString()
                (string) $errors
            );
            
        } else {
            $session->getFlashBag()->add(
                'notice',
                'Both rules are valid !'
            );
        }
        
        return $this->redirect($this->generateUrl('jmlamo_demo_validation_index'));
    }
    
    /**
     * @Route("/validation/set-iban/{premium}/{iban}")
     */
    public function setIbanAction(Request $request, $premium, $iban = null)
    {
        $validator = $this->get('validator');
        $session = $request->getSession();
    
        $author = new Author();
        $author->setName('Cresus');
        
        $author->setPremium((boolean) $premium);
        $author->setIban($iban);
    
        $errors = $validator->validate($author, null, $author->getGroupSequence());
    
        if (count($errors) > 0) {
            $session->getFlashBag()->add(
                'notice',
                // @see __toString()
                (string) $errors
            );
    
        } else {
            $premium = $author->getPremium();
            if ($premium) {
                $session->getFlashBag()->add(
                    'notice',
                    'Premium user, IBAN ok'
                );
            } else {
                $session->getFlashBag()->add(
                    'notice',
                    'Classic user, IBAN not required'
                );
            }
        }
    
        return $this->redirect($this->generateUrl('jmlamo_demo_validation_index'));
    }
    
    /**
     * @Route("/validation/check-email/{email}/{strict}")
     */
    public function checkEmailAction(Request $request, $email, $strict = false)
    {
        $validator = $this->get('validator');
        $session = $request->getSession();
        
        $emailConstraint = new Email();

        $emailConstraint->message = 'Invalid email address';
        
        if ($strict) {
            $emailConstraint->checkMX = true;
            $emailConstraint->checkHost = true;
        }
        
        $errors = $validator->validate(
            $email,
            $emailConstraint
        );
        
        if (count($errors) > 0) {
            $session->getFlashBag()->add(
                'notice',
                // @see __toString()
                (string) $errors
            );
        } else {
            $session->getFlashBag()->add(
                'notice',
                'This email is valid !'
            );
        }
        
        return $this->redirect($this->generateUrl('jmlamo_demo_validation_index'));
    }
    
    /**
     * @Route("/validation/check-bic/{bic}")
     */
    public function checkBicAction(Request $request, $bic)
    {
        $validator = $this->get('validator');
        $session = $request->getSession();
    
        $bicConstraint = new Bic();
    
        $errors = $validator->validate(
            $bic,
            $bicConstraint
        );
    
        if (count($errors) > 0) {
            $session->getFlashBag()->add(
                'notice',
                // @see __toString()
                (string) $errors
            );
        } else {
            $session->getFlashBag()->add(
                'notice',
                'This BIC is valid !'
            );
        }
    
        return $this->redirect($this->generateUrl('jmlamo_demo_validation_index'));
    }
    
    /**
     * @Route("/validation/set-bic/{bic}")
     */
    public function setBicAction(Request $request, $bic)
    {
        $validator = $this->get('validator');
        $session = $request->getSession();
    
        $author = new Author();
        $author->setName('BIC Tester');
        $author->setBic($bic);
    
        $errors = $validator->validate($author);
    
        if (count($errors) > 0) {
            $session->getFlashBag()->add(
                'notice',
                // @see __toString()
                (string) $errors
            );
    
        } else {
            $session->getFlashBag()->add(
                'notice',
                sprintf('%s is valid !', $author->getBic())
            );
        }
    
        return $this->redirect($this->generateUrl('jmlamo_demo_validation_index'));
    }

}
