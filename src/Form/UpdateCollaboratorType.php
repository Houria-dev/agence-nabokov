<?php

namespace App\Form;

use App\Entity\Collaborator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateCollaboratorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
<<<<<<< HEAD
                'label' => false,
                'required' => true
            ])
            ->add('lastname', TextType::class, [
                'label' => false,
                'required' => true
            ])
            ->add('biography', TextareaType::class, [
                'label' => false
            ])
=======
                'label' => 'prénom :',
                'required' => true
            ])
            ->add('lastname', TextType::class, [
                'label' => 'nom :',
                'required' => true
            ])
            ->add('biography', TextareaType::class, [
                'label' => 'biography :',
            ])
            ->add('save', SubmitType::class,['label'=>'Modifier ce collaborateur'])
>>>>>>> main
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Collaborator::class,
        ]);
    }
}
