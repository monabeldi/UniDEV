<?php

namespace App\Controller;

use App\Entity\Uber;
use App\Form\UberType;
use App\Repository\UberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\File\File;
use App\Service\ImageUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\FormType;

/**
 * @Route("/uber")
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_ADMIN")
 */
class UberController extends AbstractController
{
    /**
     * @Route("/", name="uber_index", methods={"GET"})
     */
    public function index(UberRepository $uberRepository): Response
    {
        return $this->render('uber/index.html.twig', [
            'ubers' => $uberRepository->findAll(),
        ]);
    }
    /**
     * @Route("/search", name="search_uber")
     */
    public function searchUberx(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Uber::class);
        $requestString = $request->get('searchValue');
        $ubers = $repository->findUberByNom($requestString);
        $jsonContent = $Normalizer->normalize($ubers, 'json',[]);

        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/new", name="uber_new", methods={"GET","POST"})
     * @param Request $request
     * @param ImageUploader $imageUploader
     * @return Response
     */
    public function new(Request $request, ImageUploader $imageUploader): Response
    {
        $uber = new Uber();
        $form = $this->createForm(UberType::class, $uber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('photo_uber')->getData();
            if ($imageFile) {
                $imageFileName = $imageUploader->upload($imageFile);
                $uber->setPhotoUber($imageFileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($uber);
            $entityManager->flush();

            return $this->redirectToRoute('uber_index');
        }

        return $this->render('uber/new.html.twig', [
            'uber' => $uber,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="uber_show", methods={"GET"})
     */
    public function show(Uber $uber): Response
    {
        return $this->render('uber/show.html.twig', [
            'uber' => $uber,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="uber_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Uber $uber
     * @param ImageUploader $imageUploader
     * @return Response
     */
    public function edit(Request $request, Uber $uber, ImageUploader $imageUploader ): Response
    {
        $fileName = $uber->getPhotoUber();
        $form = $this->createForm(UberType::class, $uber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $brochureFile = $form->get('photo_Uber')->getData();
            if ($brochureFile) {
                $brochureFileName = $imageUploader->upload($brochureFile);
                $uber->getPhotoUber($brochureFileName);
            } else {
                $uber->getPhotoUber($fileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('uber_index');
        }

        return $this->render('uber/edit.html.twig', [
            'uber' => $uber,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="uber_delete", methods={"POST"})
     */
    public function delete(Request $request, Uber $uber): Response
    {
        if ($this->isCsrfTokenValid('delete'.$uber->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($uber);
            $entityManager->flush();
        }

        return $this->redirectToRoute('uber_index');
    }
}
