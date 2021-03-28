<?php

namespace App\Controller;


use App\Entity\Chambre;
use App\Form\ChambreType;
use App\Repository\ChambreRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChambreController extends AbstractController
{
    /**
     * @Route("/chambre", name="chambre")
     */
    public function index(): Response
    {
        return $this->render('chambre/index.html.twig', [
            'controller_name' => 'ChambreController',
        ]);
    }



    /**
     * @param ChambreRepository $repository
     * @return \Symfony\Component\HttpFoundation\Reponse
     * @Route("chambre/AfficheC",name="AfficheC")
     */
    public function AfficheD(ChambreRepository $repository){
        $Chambre=$repository->findAll();
        return $this->render('chambre/AfficheD.html.twig',['Chambre'=>$Chambre]);

    }
    /**
     * @param  $request
     * @return Response
     * @route("chambre/Add", name="neww")
     */
    function Add(Request $request){
        $Chambre=new chambre();
        $form=$this->createForm(ChambreType::class,$Chambre);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {



            $em = $this->getDoctrine()->getManager();
            $em->persist($Chambre);
            $em->flush();
            return $this->redirectToRoute('AfficheC');
        }
        return $this->render('chambre/Add.html.twig',[
            'form'=>$form->createView()
        ]);
    }



    /**
     * @route ("/Supp/{idchambre}",name="b")
     */
    function Delete($idchambre ,ChambreRepository $repository){
        $Chambre=$repository->find($idchambre);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Chambre);
        $em->flush();
        return $this->redirectToRoute('AfficheC');

    }
    /**

     * @route ("chambre/Update/{idchambre}",name="updat")
     */
    function Update(ChambreRepository $repository,$idchambre,Request $request){
        $Chambre=$repository->find($idchambre);
        $form=$this->createForm(ChambreType::class,$Chambre);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheC');
        }
        return $this->render('chambre/Update.html.twig',[
            'form'=>$form->createView()
        ]);

    }
}
