<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Form\UpdateAuthorType;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AuthorController extends AbstractController
{
    /**
    * @Route("/auteurs", name="author_visitor_index")
    */
    public function index(AuthorRepository $authorRepository)
    {
        $authors = $authorRepository->findAllOrdredByName();
        return $this->render('visiteur/author/index.html.twig', [
            'authors' => $authors,
        ]);
    }
    
    /**
     * @Route("/admin/auteurs", name="author_index")
     */
    public function indexpage(AuthorRepository $authorRepository)
    {
        $authors = $authorRepository->findAllOrdredByName();
        return $this->render('administrator/author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    /**
     * @Route("/admin/auteurs/nouveau", name="author_new")
     */
    public function new(Request $request, AuthorRepository $authorRepository)
    {
        $author = new Author;

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid())
        {   
            $nom=$author->getLastName();
            $prenom=$author->getFirstName();
            $authorexist=$authorRepository->findAuthor($nom,$prenom);
            if($authorexist==null)
            {   
                $em = $this->getDoctrine()->getManager();

                $em->persist($author);
                $em->flush();

                $this->addFlash("add_author_success", "L'auteur.ice a bien été ajouté.e !");
            }
            else
            {
                $this->addFlash("author_alreadyExist", "Cet.te auteur.ice existe déjà!");
            }
            return $this->redirectToRoute('author_index');
        }

        return $this->render('administrator/author/new.html.twig', [
            'formAuthor' => $form->createView()
        ]);
    }


     /**
     * @Route("/admin/auteurs/editer/{id}", name="author_edit")
     */    
    public function edit($id, Request $request, AuthorRepository $authorRepository)
    {
        $author = $authorRepository->find($id);
        if($author!=null)
            {$form = $this->createForm(UpdateAuthorType::class, $author);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $this->addFlash("edit_author_success", "L'auteur.ice a bien été modifié.e !");

                return $this->redirectToRoute('author_index');
            }
            
            return $this->render('administrator/author/update.html.twig', [
                'formAuthor' => $form->createView()
            ]);  
        }   
        else
        {
            $this->addFlash("author_notFound", "Cet.te auteur.ice n'existe pas!");
            return $this->redirectToRoute('author_index');  
        }
         
    }

    
    /**
     * @Route("/auteurs/afficher/{id}", name="author_show")
    */
    public function show($id, AuthorRepository $authorRepository)
    {
        $author = $authorRepository->find($id);
        if($author!=null)
        {   
            return $this->render('visiteur/author/show.html.twig', [
                'author' => $author
            ]);
        }
        else
        {
            $this->addFlash("author_notFound", "Cet.te auteur.ice n'existe pas!");
            return $this->redirectToRoute('author_index');  
        }
    } 
  
    /**
     * @Route("/admin/auteurs/supprimer/{id}", name="author_delete")
     */
    public function delete($id, AuthorRepository $authorRepository)
    {
        $author = $authorRepository->find($id);
        if(!$author)
        {
            die("Aucun auteur trouvé !");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($author);
        $em->flush();
         $this->addFlash("delete_author_success", "L'auteur.ice a bien été supprimé.e !");

        return $this->redirectToRoute('author_index');
    }
  
}
