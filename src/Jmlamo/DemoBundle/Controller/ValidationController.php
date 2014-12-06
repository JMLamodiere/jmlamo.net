<?php

namespace Jmlamo\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Jmlamo\DemoBundle\Entity\Author;

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

}
