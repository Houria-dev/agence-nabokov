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
     * @Route("/auteurs", name="author_index")
     */
    public function indexpage(AuthorRepository $authorRepository)
    {
        $authors = $authorRepository->findAll();
        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    /**
     * @Route("/admin/auteurs/new", name="author_new")
     */
    public function new(Request $request)
    {
        $author = new Author;

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        //Verifie si le bouton a été cliqué
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($author);
            $em->flush();

            $this->addFlash("add_author_success", "L'auteur a bien été ajouté !");

            return $this->redirectToRoute('author_index');
        }

        return $this->render('author/new.html.twig', [
            'formAuthor' => $form->createView()
        ]);
    }


     /**
     * @Route("/admin/auteurs/edit/{idAuthor}", name="author_edit")
     */    
    public function edit($idAuthor, Request $request, AuthorRepository $authorRepository)
    {
        $author = $authorRepository->find($idAuthor);
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('author_index');
        }
        
        return $this->render('author/new.html.twig', [
            'formAuthor' => $form->createView()
        ]);        
    }


     /**
     * @Route("/auteurs/{idAuthor}", name="author_show")
     */
    public function show($idAuthor, AuthorRepository $authorRepository)
    {
        $author = $authorRepository->find($idAuthor);

        if(!$author)
        {
            die("Aucun auteur trouvé !");
        }

        return $this->render('author/show.html.twig', [
            'author' => $author
        ]);
    } 

    /**
     * @Route("/admin/auteurs/delete/{idAuthor}", name="author_delete")
     */
    public function delete($idAuthor, AuthorRepository $authorRepository)
    {
        $author = $authorRepository->find($idAuthor);
        if(!$author)
        {
            die("Aucun auteur trouvé !");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('author_index');
    }
  
}