<?php

namespace App\Controller;

use App\Entity\Transports;
use App\Form\TransportsType;
use App\Repository\TransportsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\ImageUploader;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/transports")
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_ADMIN")
 */

class TransportsController extends AbstractController
{
    /**
     * @Route("/", name="transports_index", methods={"GET"})
     */
    public function index(TransportsRepository $transportsRepository): Response
    {
        return $this->render('transports/index.html.twig', [
            'transports' => $transportsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="transports_new", methods={"GET","POST"})
     */
    public function new(Request $request, ImageUploader $imageUploader): Response
    {
        $transport = new Transports();
        $form = $this->createForm(TransportsType::class, $transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('photo_uber')->getData();
            if ($imageFile) {
                $imageFileName = $imageUploader->upload($imageFile);
                $transport->setPhotoUber($imageFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($transport);
            $entityManager->flush();

            return $this->redirectToRoute('transports_index');
        }

        return $this->render('transports/new.html.twig', [
            'transport' => $transport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="transports_show", methods={"GET"})
     */
    public function show(Transports $transport): Response
    {
        return $this->render('transports/show.html.twig', [
            'transport' => $transport,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="transports_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Transports $transport, ImageUploader $imageUploader): Response
    {
        $fileName = $transport->getPhotoTransport();
        $form = $this->createForm(TransportsType::class, $transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $brochureFile = $form->get('photo_transport')->getData();
            if ($brochureFile) {
                $brochureFileName = $imageUploader->upload($brochureFile);
                $transport->getPhotoTransport($brochureFileName);
            } else {
                $transport->getPhotoTransport($fileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transports_index');
        }

        return $this->render('transports/edit.html.twig', [
            'transport' => $transport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="transports_delete", methods={"POST"})
     */
    public function delete(Request $request, Transports $transport): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transport->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($transport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('transports_index');
    }
}
