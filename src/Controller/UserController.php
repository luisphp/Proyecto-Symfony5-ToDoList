<?php

namespace App\Controller;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends AbstractController
{

    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        //Crear objeto user del modelo User.
        $user = new User();

        //Crear formulario
        $form = $this->createForm(RegisterType::class, $user); 

        //recibir datos del formulario
        $form->handleRequest($request);

        //Comprobar si se envio el formulario

        if($form->isSubmitted() && $form->isValid()){

            //Modificando el objeto para guardarlo
            $user->setRole('ROLE_USER');

            //fijar fecha
            //$date_now = (new \DateTime())->format('d-m-Y H:i:s');
            $user->setcreatedAt(new \DateTime('now'));

            //Cifrar la contraseña
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            //var_dump($user);

            //Guardar usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('tasks_index');
        }


        return $this->render('user/register.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->CreateView(),    
        ]);
    }

    public function login(AuthenticationUtils $autenticaionUtils){
        $error = $autenticaionUtils->getLastAuthenticationError();
        
        $lastUserName = $autenticaionUtils->getLastUsername();

        return $this->render('user/login.html.twig',[
            'error' => $error,
            'last_username' => $lastUserName,
        ]);
    }

}
