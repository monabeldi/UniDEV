<?php

namespace App\Controller;

use App\Entity\Guides;
use App\Form\GuidesType;
use App\Form\SearchType;
use App\Repository\GuidesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * @Route("/guides")
 */
class GuidesController extends AbstractController
{
    /**
     * @Route("/", name="guides_index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $guide = new Guides();
        $form = $this->createForm(SearchType::class, $guide);
        $form->handleRequest($request);
        $guides= [];
        $guides= $this->getDoctrine()->getRepository(Guides::class)->findAll();


        if($form->isSubmitted() && $form->isValid()) {
            $nom = $guide->getNomGui();
            $etat = $guide->getEtatGui();
            if ($nom!="")
                $guides= $this->getDoctrine()->getRepository(Guides::class)->findBy(['nom_gui' => $nom] );
            else
                if($etat!=""){
                    $guides= $this->getDoctrine()->getRepository(Guides::class)->findBy(['etat_gui' => $etat] );

                }else
                    $guides= $this->getDoctrine()->getRepository(Guides::class)->findAll();
        }
        return  $this->render('guides/index.html.twig',[ 'form' =>$form->createView(), 'guides' => $guides]);

    }


    /**
     * @Route("/new", name="guides_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $guide = new Guides();
        $form = $this->createForm(GuidesType::class, $guide);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $guide->getPhotoGui();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e){
            }
            $entityManager = $this->getDoctrine()->getManager();
            $guide->setPhotoGui($fileName);
            $entityManager->persist($guide);
            $entityManager->flush();

            return $this->redirectToRoute('guides_index');
        }

        return $this->render('guides/new.html.twig', [
            'guide' => $guide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="guides_show", methods={"GET"})
     */
    public function show(Guides $guide): Response
    {
        return $this->render('guides/show.html.twig', [
            'guide' => $guide,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="guides_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Guides $guide): Response
    {
        $form = $this->createForm(GuidesType::class, $guide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploaded_file = $form['photo_gui']->getData();
            if ($uploaded_file) {
                $image = GuidesType::processImage($uploaded_file);
                $guide->setPhotoGui($image);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('guides_index');
        }

        return $this->render('guides/edit.html.twig', [
            'guide' => $guide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="guides_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Guides $guide): Response
    {
        if ($this->isCsrfTokenValid('delete'.$guide->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($guide);
            $entityManager->flush();
        }

        return $this->redirectToRoute('guides_index');
    }

    /**
     * @Route("/supprime/image/{id}", name="annonces_delete_image", methods={"DELETE"})
     * @param Images $image
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteImage(Images $image, Request $request){
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            // On récupère le nom de l'image
            $nom = $image->getName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory').'/'.$nom);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
