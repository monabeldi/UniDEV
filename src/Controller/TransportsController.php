<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Entity\Transports;
use App\Entity\Uber;
use App\Form\TransportsType;
use App\Repository\CarsRepository;
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
     * @Route("/unreserved", name="transports_indexFront", methods={"GET"})
     */
    public function indexFront(): Response
    {   $cars=$this->getDoctrine()->getRepository(Cars::class)->findAllNOTRESERVED();
        $ubers=$this->getDoctrine()->getRepository(Uber::class)->findAllNOTRESERVED();
         return $this->render('transports/indexFront.html.twig', [
            'cars' => $cars,
             'ubers'=> $ubers
        ]);
    }
    /**
     * @Route("/{id}/bookcar", name="transports_newCar", methods={"GET","POST"})
     */
    public function reserverCar(Cars $cars): Response
    {
        $transport = new Transports();
        $transport->setCar($cars);
        $transport->setUserId($this->getUser()->getId());
        $transport->setType('car');
        $transport->setEtatTransport('bon etat');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($transport);
        $entityManager->flush();
        return $this->redirectToRoute('transports_indexFront');
    }
    /**
     * @Route("/{id}/bookuber", name="transports_newUber", methods={"GET","POST"})
     */
    public function reserverUber(Uber $uber): Response
    {
        $transport = new Transports();
        $transport->setUber($uber);
        $transport->setUserId($this->getUser()->getId());
        $transport->setType('uber');
        $transport->setEtatTransport('Active');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($transport);
        $entityManager->flush();
        return $this->redirectToRoute('transports_indexFront');
    }
    /**
     * @Route("/myreservations", name="transports_myReservations", methods={"GET"})
     */
    public function indexReservation(): Response
    {   $cars=$this->getDoctrine()->getRepository(Cars::class)->findMyreserved($this->getUser()->getId());
        $ubers=$this->getDoctrine()->getRepository(Uber::class)->findMyreserved($this->getUser()->getId());
        return $this->render('transports/mesReservationsFront.html.twig', [
            'cars' => $cars,
            'ubers'=> $ubers
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
    /*public function delete(Request $request, Transports $transport): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transport->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($transport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('transports_index');
    }*/
    /**
 * @Route("/{id}", name="transports_delCar")
 */
    public function deleteCar($id)
    {
            $entityManager = $this->getDoctrine()->getManager();
            $transport=$entityManager->getRepository(Transports::class)->find(12);
            $entityManager->remove($transport);
            $entityManager->flush();

        return $this->redirectToRoute('transports_myReservations');
    }
    /**
    * @Route("/{id}", name="transports_delUber")
    */
    public function deleteUber($id): Response
    {    $transport=$this->getDoctrine()->getRepository(Transports::class)->findSelectedUber($this->getUser()->getId(),$id);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($transport);
            $entityManager->flush();


        return $this->redirectToRoute('transports_myReservations');
    }
}
