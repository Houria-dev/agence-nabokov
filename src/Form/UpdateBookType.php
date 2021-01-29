<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use Doctrine\DBAL\Types\DateType as TypesDateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\DateTime;

class UpdateBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label'=> false, 
                'required'=>true
            ])
            ->add('description',  TextareaType::class, [
                'label'=> false, 
                'required'=>false
            ])
            ->add('editor', TextType::class, [
                'label'=> false, 
                'required'=>false])
            ->add('publication_date', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
                'label'=> false, 
                'required'=>true
            ])
            ->add('imageFile',FileType::class,
            [
                'required' => false,
                'label' => false
            ])

            ->add('auteur', EntityType::class,  array(
                'class' => Author::class,
                'choice_label' => function($author) {
                     return $author-> getFirstName().' '.$author->getLastName(); 
                 },
                'choice_value' => 'firstName',
                'label' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
