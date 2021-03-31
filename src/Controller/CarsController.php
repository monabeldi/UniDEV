<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Form\CarsType;
use App\Repository\CarsRepository;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cars")
 */
class CarsController extends AbstractController
{
    /**
     * @Route("/", name="cars_index", methods={"GET"})
     */
    public function index(CarsRepository $carsRepository): Response
    {
        return $this->render('cars/index.html.twig', [
            'cars' => $carsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cars_new", methods={"GET","POST"})
     */
    public function new(Request $request, ImageUploader $imageUploader ): Response
    {
        $car = new Cars();
        $form = $this->createForm(CarsType::class, $car);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('photo_car')->getData();
            if ($imageFile) {
                $imageFileName = $imageUploader->upload($imageFile);
                $car->setPhotoCar($imageFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('cars_index');
        }

        return $this->render('cars/new.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cars_show", methods={"GET"})
     */
    public function show(Cars $car): Response
    {
        return $this->render('cars/show.html.twig', [
            'car' => $car,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cars_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Cars $car
     * @param ImageUploader $imageUploader
     * @return Response
     */
    public function edit(Request $request, Cars $car, ImageUploader $imageUploader ): Response
    {
        $fileName = $car->getPhotoCar();
        $car->setPhotoCar(
            new File($this->getParameter('images_directory').'/'.$car->getPhotoCar())
        );
        $form = $this->createForm(CarsType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $brochureFile = $form->get('photo_car')->getData();
            if ($brochureFile) {
                $brochureFileName = $imageUploader->upload($brochureFile);
                $car->setPhotoCar($brochureFileName);
            } else {
                $car->setPhotoCar($fileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cars_index');
        }

        return $this->render('cars/edit.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cars_delete", methods={"POST"})
     */
    public function delete(Request $request, Cars $car): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cars_index');
    }
}
