<?php 
	
	namespace App\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;

	class RegisterType extends AbstractType{

		public function buildForm(FormBuilderInterface $builder, array $options){
			$builder->add('name', TextType::class, array(
				'label' => 'Nombre',
				'attr' => ['class' => 'form-control']				
			));
			$builder->add('surname', TextType::class, array(
				'label' => 'Apellido',
				'attr' => ['class' => 'form-control']				
			));
			$builder->add('email', EmailType::class, array(
				'label' => 'Email',
				'attr' => ['class' => 'form-control']			
			));
			$builder->add('password', PasswordType::class, array(
				'label' => 'Contraseña',
				'attr' => ['class' => 'form-control']				
			));
			$builder->add('submit', SubmitType::class, array(
				'label' => 'Registrar',
				'attr' => ['class' => ' btn btn-success']				
			));
		}

	}