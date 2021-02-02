<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use App\Form\BookType;
use App\Form\UpdateBookType;

class BookController extends AbstractController
{
    /**
     * @Route("/admin/livres", name="book_index")
     */
    public function allBooks(): Response
    {
        $books= $this->getDoctrine()->getRepository(Book::class)->findAllOrdredByDate();
        return $this->render('administrator/book/index.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * @Route("/admin/livres/nouveau", name="book_new")
     */
    public function add(Request $request) 
    {
        $book=new Book;
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $title=$book->getTitle();
            $editor=$book->getEditor();
            $publication=$book->getPublicationDate();
            $bookExist=$this->getDoctrine()->getRepository(Book::class)->findBook($title,$editor,$publication);
            if ($bookExist==null)
            {
                $em = $this->getDoctrine()->getManager();

                $em->persist($book);
                $em->flush();

                $this->addFlash("add_book_success", "Le livre a bien été  ajouté !");
            }
            else{
                $this->addFlash("book_already_exist", "Le livre existe déjà!");
            }

            return $this->redirectToRoute('book_index');
        }

        return $this->render('administrator/book/new.html.twig', [
            'formBook' => $form->createView(),
        ]);

    }
    /**
     * @Route("/admin/livres/editer/{id}", name="book_edit")
     */
    public function edit(Request $request, $id) 
    {
        $book=$this->getDoctrine()->getRepository(Book::class)->find($id);

        if($book!=null)
        {   
            $form = $this->createForm(UpdateBookType::class, $book);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $em->flush();

                $this->addFlash("edit_book_success", "Le livre a bien été modifié !");

                return $this->redirectToRoute('book_index');
            }

            return $this->render('administrator/book/update.html.twig', [
                'formBook' => $form->createView(),
            ]);
        }
        else{
            $this->addFlash("book_notFound", "Ce livre n'existe pas!");
            return $this->redirectToRoute('book_index');
        }
    }

    /**
     * @Route("/admin/livres/supprimer/{id}", name="book_delete")
     */
    public function delete($id) 
    {
        $book=$this->getDoctrine()->getRepository(Book::class)->find($id);
        

        
        $em = $this->getDoctrine()->getManager();
        $em->remove($book);
        $em->flush();

        $this->addFlash("delete_book_success", "Le livre a bien été supprimé !");

        return $this->redirectToRoute('book_index');
        

        
    }

    // /**
    //  * @Route("/livre/{id}", name="book_show")
    // */
    // public function show($id)
    // {
    //     $book =$this->getDoctrine()->getRepository(Book::class)->find($id);

    //     return $this->render('visiteur/book/show.html.twig', [
    //         'book' => $book
    //     ]);
    // } 

    /**
    * @Route("/", name="home_index")
    */
    public function index()
    {
        $books = $this->getDoctrine()->getRepository(Book::class)->findAllOrdredByDateAndLimited();
        return $this->render('index.html.twig', [
            'lastBooks' => $books,
        ]);
    }

}
