<?php

namespace App\Controller;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer): Response
    {   $contact=new Contact;
        $contact->setSentAt(new \Datetime());
        $form=$this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $message=(new \Swift_Message("[NOUVEAU MESSAGE] " . $contact->getSujet()))
            ->setFrom($contact->getEmail())
            ->setTo("agenceNabokov@htomail.fr")
            ->setReplyTo($contact->getEmail())
            ->setBody(
                $this->renderView('visiteur/emails/sendEmail.html.twig', ['contact'=>$contact]),'text/html');
            $mailer->send($message);
            $this->addFlash('success_mail', 'Le mail a bien été envoyé !');
            return $this->redirectToRoute('contact');
        }
        return $this->render('visiteur/contact/index.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/manuscrit", name="manuscrit")
     */
    public function page()
    {
        return $this->render('visiteur/manuscrits/manuscrits.html.twig');
    }
}
