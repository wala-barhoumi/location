<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\form\VoitureForm;

class VoitureController extends AbstractController
{

    #[Route('/voiture', name: 'voiture')]
    public function listVoiture(EntityManagerInterface $em): Response
    {
        $voitures = $em->getRepository("App\Entity\Voiture")->findAll();

        return $this->render('voiture/listVoiture.html.twig', [
            "listVoiture" => $voitures
        ]);

    }
    #[Route('/addvoiture', name: 'addvoiture')]
    public function addVoiture(Request $request,EntityManagerInterface $em){
        $voiture=new Voiture();
        $form=$this->createForm(VoitureForm::class,$voiture);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute("voiture");
        }
        return $this->render("voiture/addVoiture.html.twig",["formV"=>$form->createView()]);
    }
   #[Route('/voiture/{id}', name: 'voitureDelete')]
     public function delete(EntityManagerInterface $em, $id,VoitureRepository$vr):Response
   {
       $voiture=$vr->find($id);
       $em->remove($voiture);
       $em->flush();
       return  $this->redirectToRoute('voiture');
   }
    #[Route('/updatevoiture/{id}', name: 'voitureUpdate')]
public function updateVoiture(Request $request,EntityManagerInterface $em, $id,VoitureRepository$vr):Response
    {
        $voiture=$vr->find($id);
        $editform =$this->createForm(voitureForm::class,$voiture);
        $editform->handleRequest($request);
        if($editform->isSubmitted()and $editform->isValid()){
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('voiture');
        }
return $this->render('voiture/updateVoiture.html.twig',['editFormVoiture'=>$editform->createView()]);


    }

}
