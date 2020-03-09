<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\TaskType;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskController extends AbstractController
{

    public function index()
    {
        //Sacar todas las entidades que tenemos en la base de datos
        $em = $this->getDoctrine()->getManager();
        $task_repo = $this->getDoctrine()->getRepository(Task::class);

        $tasks = $task_repo->findBy(array(), array('id' => 'DESC'));

        /*
        foreach ($tasks as $task) {
            echo $task->getTitle()."<br>";
        }
        */
        


        return $this->render('task/index.html.twig', [
        	'controller_name' => 'Saludos',
            'tasks' => $tasks,
        ]);
    }

    public function detail(Task $task){
        if(!$task){
            return $this->redirectToRoute('tasks');
        }else{
            return $this->render('task/detail.html.twig',[
                'task' => $task
            ]);
        }
    }

    public function creation(Request $request, UserInterface $user){

        $task = new Task();
        $form = $this->createForm(TaskType::class,$task);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $task->setcreatedAt(new \DateTime('now'));
            $task->setUser($user);

            $em =  $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect(

                $this->generateUrl('task_detail',['id'=> $task->getId()])
            );

            //var_dump($form);
            //die();
            
        }
        return $this->render('task/create.html.twig',[
            'form' => $form->createView()
            ]);
    }

    public function MyTasks(UserInterface $user){
        $tasks = $user->getTasks();

        return $this->render('user/mytasks.html.twig',[
            'tasks' => $tasks
        ]);
    }

    public function edit(Request $request,Task $task, UserInterface $user){

        //Verificamos si esta logeado algun usuario y si el post que intenta editar es el suyo

        if(!$user || $user->getId() != $task->getUser()->getId()){

            return $this->redirect(
    
                $this->generateUrl('task_detail',['id'=> $task->getId()])
            );

        }else{

            //En caso de que este logeado y el post sea el suyo 

            $form = $this->createForm(TaskType::class,$task);

            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
                //$task->setcreatedAt(new \DateTime('now'));
                //$task->setUser($user);
    
                $em =  $this->getDoctrine()->getManager();
                $em->persist($task);
                $em->flush();
    
                return $this->redirect(
    
                    $this->generateUrl('task_detail',[
                        'id'=> $task->getId(),
                        ])
                );
    
                //var_dump($form);
                //die();

        }  
        }



        return $this->render('task/create.html.twig',[
            'edit' => true,
            'form' => $form->createView()

            ]);
    }

    public function delete(Task $task, UserInterface $user){

        if(!$user || $user->getId() != $task->getUser()->getId()){

            return $this->redirect(
    
                $this->generateUrl('task_detail',['id'=> $task->getId()])
            );

        }else{

            if($task){

                $em =  $this->getDoctrine()->getManager();
                $em->remove($task);
                $em->flush();

                return $this->redirectToRoute('tasks_index');
            }

        }      
        return $this->redirectToRoute('tasks_index');
    }
}
