<?php

namespace App\Controller;

use App\Entity\Boutique;
use App\Form\Boutique1Type;
use App\Repository\BoutiqueRepository;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


/**
 * @Route("/boutique")
 */
class BoutiqueController extends AbstractController
{
    /**
     * @Route("/", name="boutique_index", methods={"GET"})
     */
    public function index(BoutiqueRepository $boutiqueRepository): Response
    {
        return $this->render('boutique/index.html.twig', [
            'boutiques' => $boutiqueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/json", name="boutique_index", methods={"GET"})
     */
    public function indexjson(BoutiqueRepository $boutiqueRepository,NormalizerInterface $Normalizer): Response
    {
        $boutique =$boutiqueRepository->findAll();
        $jsonContent=$Normalizer->normalize($boutique,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/new", name="boutique_new", methods={"GET","POST"})
     */
    public function new(Request $request, ImageUploader $imageUploader): Response
    {

        $boutique = new Boutique();
        $form = $this->createForm(Boutique1Type::class, $boutique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('photoBoutique')->getData();
            if ($imageFile) {
                $imageFileName = $imageUploader->upload($imageFile);
                $boutique->setPhotoBoutique($imageFileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($boutique);
            $entityManager->flush();

            return $this->redirectToRoute('boutique_index');
        }

        return $this->render('boutique/new.html.twig', [
            'boutique' => $boutique,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newjson/new", name="boutique_new_json", methods={"GET","POST"})
     */
    public function newJson(Request $request, ImageUploader $imageUploader ,NormalizerInterface $Normalizer): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $boutique = new Boutique();
        $boutique->setNomBoutique($request->get('nom_boutique'));
        $boutique->setAddressBoutiques($request->get('address_boutiques'));
        $boutique->setNumTelBoutique($request->get('num_tel_boutique'));
        $boutique->setEmailBoutique($request->get('email_boutique'));
        $boutique->setPhotoBoutique($request->get('photo_boutique'));


        $entityManager->persist($boutique);
        $entityManager->flush();

        $jsonContent=$Normalizer->normalize($boutique,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));

    }




    /**
     * @Route("/{id}",requirements={"id"="\d+"}, name="boutique_show", methods={"GET"})
     */
    public function show(Boutique $boutique): Response
    {
        return $this->render('boutique/show.html.twig', [
            'boutique' => $boutique,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="boutique_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Boutique $boutique,ImageUploader $imageUploader): Response
    {
        $fileName = $boutique->getPhotoBoutique();
        $boutique->setPhotoBoutique(
            new File($this->getParameter('images_directory').'/'.$boutique->getPhotoBoutique())
        );
        $form = $this->createForm(Boutique1Type::class, $boutique);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $imageFile */
            $brochureFile = $form->get('PhotoBoutique')->getData();
            if ($brochureFile) {
                $brochureFileName = $imageUploader->upload($brochureFile);
                $boutique->setPhotoBoutique($brochureFileName);
            } else {
                $boutique->setPhotoBoutique($fileName);
            }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('boutique_index');
        }

        return $this->render('boutique/edit.html.twig', [
            'boutique' => $boutique,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}/editjson", name="boutique_edit", methods={"GET","POST"})
     */
    public function editjson(Request $request, Boutique $boutique,ImageUploader $imageUploader
        ,NormalizerInterface $Normalizer): Response
    {
        $fileName = $boutique->getPhotoBoutique();
        $boutique->setPhotoBoutique(
            new File($this->getParameter('images_directory').'/'.$boutique->getPhotoBoutique())
        );
        $form = $this->createForm(Boutique1Type::class, $boutique);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $imageFile */
            $brochureFile = $form->get('PhotoBoutique')->getData();
            if ($brochureFile) {
                $brochureFileName = $imageUploader->upload($brochureFile);
                $boutique->setPhotoBoutique($brochureFileName);
            } else {
                $boutique->setPhotoBoutique($fileName);
            }


            $this->getDoctrine()->getManager()->flush();


        }
        $jsonContent=$Normalizer->normalize($boutique,'json',['groups'=>'post:read']);
        return new Response("Boutique update succefully".json_encode($jsonContent));

    }

    /**
     * @Route("/{id}", name="boutique_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Boutique $boutique): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boutique->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($boutique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('boutique_index');
    }

    /**
     * @Route("deletejson/{id}", name="boutique_delete", methods={"DELETE"})
     */
    public function deletejson(Request $request, Boutique $boutique,NormalizerInterface $Normalizer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boutique->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($boutique);
            $entityManager->flush();
        }

        $jsonContent=$Normalizer->normalize($boutique,'json',['groups'=>'post:read']);
        return new Response("Boutique delete succefully".json_encode($jsonContent));
    }

    /**
     * @Route("/searchBoutique", name="searchBoutique")
     */
    public function searchBoutique(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Boutique::class);
        $requestString=$request->get('searchValue');
        $boutique = $repository->findBoutiqueBynomBoutique($requestString);
        $jsonContent = $Normalizer->normalize($boutique, 'json',['groups'=>'boutique:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }





}
