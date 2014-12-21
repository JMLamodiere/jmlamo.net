<?php

namespace Jmlamo\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Jmlamo\DemoBundle\Entity\Task;

class FormController extends Controller
{
    /**
     * @Route("/form")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/form/new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $session = $request->getSession();
        
        // create a task and give it some dummy data for this example
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));
    
        $form = $this->createFormBuilder($task)
        ->add('task', 'text')
        ->add('dueDate', 'date')
        ->add('save', 'submit', array('label' => 'Create Task'))
        ->add('saveAndAdd', 'submit', array('label' => 'Save and Add'))
        ->getForm();
    
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            
            $message = $form->get('saveAndAdd')->isClicked()
                ? 'Task has been saved'
                : 'Task is valid';
            
            $session->getFlashBag()->add(
                'notice',
                $message
            );
            
            return $this->redirect($this->generateUrl('jmlamo_demo_form_index'));
        }
        
        return array(
            'form' => $form->createView(),
        );
    }
    
}