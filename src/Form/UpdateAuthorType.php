<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UpdateAuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'prénom :',
                'required' => true
            ])
            ->add('lastName', TextType::class, [
                'label' => 'nom :',
                'required' => true
            ])
             ->add('biography', TextareaType::class, [
                'label' => 'biography :',
                 'required' => true
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => 'image :'
            ])
            ->add('save', SubmitType::class,['label'=>'Modifier l\'auteur'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }

    
}
