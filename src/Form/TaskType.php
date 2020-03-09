<?php 
	
	namespace App\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
	use Symfony\Component\Form\Extension\Core\Type\TextareaType;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\Form\Extension\Core\Type\NumberType;

	class TaskType extends AbstractType{

		public	 function buildForm(FormBuilderInterface $builder, array $options){
			$builder->add('title', TextType::class, array(
				'label' => 'Título',
				'attr' => ['class' => 'form-control']				
			));
			$builder->add('content', TextareaType::class, array(
				'label' => 'Contenido',
				'attr' => ['class' => 'form-control']				
			));
			$builder->add('priority', ChoiceType::class, array(
				'label' => 'Prioridad',
				'choices' => array(
					'Alta' => 'Alta',
					'Media' => 'Media',
					'Baja' => 'Baja',
				)			
			));
			$builder->add('hours', TextType::class, array(
				'label' => 'Horas presupuestadas',
				'attr' => ['class' => 'form-control']				
			));
			$builder->add('submit', SubmitType::class, array(
				'label' => 'Guardar',
				'attr' => ['class' => ' btn btn-success']				
			));
		}

	}