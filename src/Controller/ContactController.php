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
            $message=(new \Swift_Message("Nouveau Message"))
            ->setFrom($contact->getEmail())
            ->setTo("agenceNabokov@htomail.fr")
            ->setReplyTo($contact->getEmail())
            ->setBody(
                $this->renderView('emails/sendEmail.html.twig', ['contact'=>$contact]),'text/html');
            $mailer->send($message);
            $this->addFlash('success_mail', 'le mail a bien été envoyé');
        }
        return $this->render('contact/index.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
}
