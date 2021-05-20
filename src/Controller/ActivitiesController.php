<?php

namespace App\Controller;

use App\Entity\Activities;
use App\Form\ActivitiesType;
use App\Repository\ActivitiesRepository;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/activities")
 */
class ActivitiesController extends AbstractController
{
    /**
     * @Route("/", name="activities_index", methods={"GET"})
     * @param ActivitiesRepository $activitiesRepository
     * @return Response
     */
    public function index(ActivitiesRepository $activitiesRepository): Response
    {
        return $this->render('activities/index.html.twig', [
            'activities' => $activitiesRepository->findAll(),
        ]);
    }

    /**
     * @param Request $request
     * @Route("/new", name="activities_new", methods={"GET","POST"})
     */
    public function new(Request $request, ImageUploader $ImageUploader): Response
    {
        $activity = new Activities();
        $form = $this->createForm(ActivitiesType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFileName = $ImageUploader->upload($imageFile);
                $activity->setImage($imageFileName);
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activity);
            $entityManager->flush();

            return $this->redirectToRoute('activities_index');
        }

        return $this->render('activities/new.html.twig', [
            'activity' => $activity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activities_show", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function show(Activities $activity): Response
    {
        return $this->render('activities/show.html.twig', [
            'activity' => $activity,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="activities_edit", methods={"GET","POST"}, requirements={"id":"\d+"})
     */
    public function edit(Request $request, Activities $activity, ImageUploader $ImageUploader): Response
    {
        $form = $this->createForm(ActivitiesType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFileName = $ImageUploader->upload($imageFile);
                $activity->setImage($imageFileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('activities_index');
        }

        return $this->render('activities/edit.html.twig', [
            'activity' => $activity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activities_delete", methods={"DELETE"}, requirements={"id":"\d+"})
     */
    public function delete(Request $request, Activities $activity): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($activity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('activities_index');
    }

    /**
     * @Route("/search", name="search_activities", requirements={"id":"\d+"})
     * @param Request $request
     * @param NormalizerInterface $Normalizer
     * @return Response
     * @throws ExceptionInterface
     */
    public function searchActivities(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Activities::class);
        $requestString = $request->get('searchValue');
        $activities = $repository->findActivitiesByNom($requestString);
        $jsonContent = $Normalizer->normalize($activities, 'json',[]);

        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/user", name="activities_user", methods={"GET"})
     * @param ActivitiesRepository $activitiesRepository
     * @return Response
     */
    public function user(ActivitiesRepository $activitiesRepository): Response
    {
        return $this->render('activities/user.html.twig', [
            'activities' => $activitiesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/recherche",name="recherche")
     */
    function recherche(ActivitiesRepository $repository, Request $request)
    {
        $data = $request->get('search_static');
        $activite = $repository->findBy(['id' => $data]);
        return $this->render('activities/index.html.twig',
            ['activities' => $activite]);
    }
}
