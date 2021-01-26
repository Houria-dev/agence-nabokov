<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AuthorController extends AbstractController
{
    /**
     * @Route("/admin/auteurs", name="author_index")
     */
    public function indexpage(AuthorRepository $authorRepository)
    {
        $authors = $authorRepository->findAll();
        return $this->render('administrator/author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    /**
     * @Route("/admin/auteurs/nouveau", name="author_new")
     */
    public function new(Request $request)
    {
        $author = new Author;

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        //Verifie si le bouton a �t� cliqu�
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($author);
            $em->flush();

            $this->addFlash("add_author_success", "L'auteur a bien �t� ajout� !");

            return $this->redirectToRoute('author_index');
        }

        return $this->render('administrator/author/new.html.twig', [
            'formAuthor' => $form->createView()
        ]);
    }


     /**
     * @Route("/admin/auteurs/{id}", name="author_edit")
     */    
    public function edit($id, Request $request, AuthorRepository $authorRepository)
    {
        $author = $authorRepository->find($id);
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash("edit_author_success", "L'auteur a bien �t� modifi� !");

            return $this->redirectToRoute('author_index');
        }
        
        return $this->render('administrator/author/new.html.twig', [
            'formAuthor' => $form->createView()
        ]);        
    }

    /*
     /**
     * @Route("/auteurs/{id}", name="author_show")
    */
    public function show($id, AuthorRepository $authorRepository)
    {
        $author = $authorRepository->find($id);

        if(!$author)
        {
            die("Aucun auteur trouv� !");
        }

        return $this->render('visiteur/author/show.html.twig', [
            'author' => $author
        ]);
    } 
  
    /**
     * @Route("/admin/auteurs/delete/{id}", name="author_delete")
     */
    public function delete($id, AuthorRepository $authorRepository)
    {
        $author = $authorRepository->find($id);
        if(!$author)
        {
            die("Aucun auteur trouv� !");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($author);
        $em->flush();
         $this->addFlash("delete_author_success", "L'auteur a bien �t� supprim� !");

        return $this->redirectToRoute('author_index');
    }
  
}