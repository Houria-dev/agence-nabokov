<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Collaborator;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CollaboratorType;
use App\Form\UpdateCollaboratorType;
use App\Repository\CollaboratorRepository;


class CollaboratorController extends AbstractController
{
    /**
     * @Route("/collaborateurs", name="collaborators")
     */
    public function listbyname(): Response
    {   $collaborators = $this->getDoctrine()->getRepository(Collaborator::class)->findAllOrdredByName();
        return $this->render('visiteur/collaborator/index.html.twig', [
            'collaborators' => $collaborators,
        ]);
    }

    // /**
    //  * @Route("/afficheCollaborateur/{id}", name="showCollaborator")
    //  */
    // public function showOne($id): Response
    // {   $collaborator= $this->getDoctrine()->getRepository(Collaborator::class)->find($id);
    //     return $this->render('visiteur/collaborator/showCollaborator.html.twig', [
    //         'collaborator' => $collaborator,
    //     ]);
    // }
     
    /**
     * @Route("/admin/collaborateurs", name="admin_collaborators")
     */
    public function affichAll(): Response
    {   $collaborators = $this->getDoctrine()->getRepository(Collaborator::class)->findAllOrdredByName();
        return $this->render('administrator/collaborator/index.html.twig', [
            'collaborators' => $collaborators,
        ]);
    }
    
    /**
     * @Route("/admin/collaborateurs/nouveau", name="admin_newCollaborators")
     */
    
     public function add(Request $request)
     {
        
       $collaborator=new Collaborator;
        $form=$this->createForm(CollaboratorType::class, $collaborator);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {   $nom=$collaborator->getLastname();
            $prenom=$collaborator->getFirstname();
            $collaboratorexist=$this->getDoctrine()->getRepository(Collaborator::class)->findCollaborator($nom,$prenom);
            if($collaboratorexist==null)
            {   
                $entityManager = $this->getDoctrine()->getManager();   
                $entityManager->persist($collaborator);
                $entityManager->flush();
                $this->addFlash('new_collaborator', 'Le collaborateur a été ajouté avec succès !');
            }
            else{

                $this->addFlash('Collab_AlreadyExist', 'Ce collaborateur existe déjà!');  
            }
            return $this->redirectToRoute('admin_collaborators');
        }

        return $this->render('administrator/collaborator/newCollaborator.html.twig', ['new_collaborator'=>$form->createView()]);

     }

     /**
     * @Route("/admin/collaborateurs/editer/{id}", name="admin_updateCollaborators",  requirements={"id"="\d+"})
     */
    
    public function update(Request $request, $id)
    {
        $collaborator=$this->getDoctrine()->getRepository(Collaborator::class)->find($id);
        if($collaborator!=null)
        {
            $form=$this->createForm(UpdateCollaboratorType::class, $collaborator);
            $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->isValid())
            {
              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->flush();
              $this->addFlash('update_collaborator', 'Le collaborateur a été modifié avec succès !');
              return $this->redirectToRoute('admin_collaborators');
            }

            return $this->render('administrator/collaborator/updateCollaborator.html.twig', ['update_collaborator'=>$form->createView()]);


        }
        
        else{
            $this->addFlash('collaborator_notFound', 'Ce collaborateur n\'existe pas');
           return  $this->RedirectToRoute("admin_collaborators");
            
        }
    }
     /**
     * @Route("/admin/collaborateur/supprimer/{id}", name="admin_deleteCollaborators",  requirements={"id"="\d+"})
     */
    public function delete($id)
    {
        $collaborator=$this->getDoctrine()->getRepository(Collaborator::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();        
        $entityManager->remove($collaborator);
        $entityManager->flush();

        $this->addFlash('delete_collaborator', 'Le collaborateur a bien été supprimé !');
          return $this->redirectToRoute('admin_collaborators');

        
    }




}
