<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{

    public function index()
    {
        //Sacar todas las entidades que tenemos en la base de datos
        $em = $this->getDoctrine()->getManager();
        $task_repo = $this->getDoctrine()->getRepository(Task::class);

        $tasks = $task_repo->findAll();

        
        foreach ($tasks as $task) {
            echo $task->getTitle()."<br>";
        }
        


        return $this->render('task/index.html.twig', [
        	'controller_name' => 'Mamagoevo',
            'tasks' => $tasks,
        ]);
    }
}
