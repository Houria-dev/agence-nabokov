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
     * @Route("/admin/livre/nouveau", name="book_new")
     */
    public function add(Request $request) 
    {
        $book=new Book;
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($book);
            $em->flush();

            $this->addFlash("add_book_success", "Le livre a bien été  ajouté !");

            return $this->redirectToRoute('book_index');
        }

        return $this->render('administrator/book/new.html.twig', [
            'formBook' => $form->createView(),
        ]);

    }
    /**
     * @Route("/admin/livre/editer/{id}", name="book_edit")
     */
    public function edit(Request $request, $id) 
    {
        $book=$this->getDoctrine()->getRepository(Book::class)->find($id);
        $form = $this->createForm(UpdateBookType::class, $book);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->flush();

            $this->addFlash("edit_book_success", "Le livre a bien été modifié !");

            return $this->redirectToRoute('book_index');
        }

        return $this->render('administrator/book/new.html.twig', [
            'formBook' => $form->createView(),
        ]);

    }

    /**
     * @Route("/admin/livre/supprimer/{id}", name="book_delete")
     */
    public function delete($id) 
    {
        $book=$this->getDoctrine()->getRepository(Book::class)->find($id);
        

        
        $em = $this->getDoctrine()->getManager();
        $em->remove($book);
        $em->flush();

        $this->addFlash("delete_book_success", "Le livre a bien été modifié !");

        return $this->redirectToRoute('book_index');
        

        
    }

    /**
     * @Route("/livre/{id}", name="book_show")
    */
    public function show($id)
    {
        $book =$this->getDoctrine()->getRepository(Book::class)->find($id);

        return $this->render('visiteur/book/show.html.twig', [
            'book' => $book
        ]);
    } 

}
