<?php

namespace App\Controller;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
    * @Route("/", name="home_index")
    */
    public function index(BookRepository $bookRepository)
    {
        $books = $bookRepository->findAllOrdredByDateAndLimited();
        return $this->render('index.html.twig', [
            'lastBooks' => $books,
        ]);
    }

}
