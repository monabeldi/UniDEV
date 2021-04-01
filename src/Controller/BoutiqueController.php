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
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



/**
 * @Route("/boutique")
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_ADMIN")
 */
class BoutiqueController extends AbstractController
{
    /**
     * @Route("/", name="boutique_index", methods={"GET"})
     */
    public function index(BoutiqueRepository $boutiqueRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Boutique::class)->findALL();
        $boutique = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1)
        );
        return $this->render('boutique/index.html.twig', [
            'boutiques' => $boutique
        ]);
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
