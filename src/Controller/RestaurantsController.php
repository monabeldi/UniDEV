<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Form\RestaurantsType;
use App\Repository\RestaurantsRepository;
use App\Service\ImageUploader;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/restaurants")
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_ADMIN")
 */
class RestaurantsController extends AbstractController
{
    /**
     * @Route("/", name="restaurants_index", methods={"GET"})
     */
    public function index(RestaurantsRepository $restaurantsRepository): Response
    {
        return $this->render('restaurants/index.html.twig', [
            'restaurants' => $restaurantsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="restaurants_new", methods={"GET","POST"})
     */
    public function new(Request $request, ImageUploader $imageUploader): Response
    {
        $restaurant = new Restaurants();
        $form = $this->createForm(RestaurantsType::class, $restaurant);
        $form->handleRequest($request);
        //$request->files
        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('photo_rest')->getData();
            if ($imageFile) {
                $imageFileName = $imageUploader->upload($imageFile);
                $restaurant->setPhotoRest($imageFileName);
            }

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('restaurants_index');
        }

        return $this->render('restaurants/new.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}",
     *     name="restaurants_show",
     *     methods={"GET"},
     *     requirements={"id"="\d+"}
     *  )
     */
    public function show(Restaurants $restaurant): Response
    {
        //param converter
        return $this->render('restaurants/show.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="restaurants_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Restaurants $restaurant, ImageUploader $imageUploader ): Response
    {
        $fileName = $restaurant->getPhotoRest();
        $restaurant->setPhotoRest(
            new File($this->getParameter('images_directory').'/'.$restaurant->getPhotoRest())
        );
        $form = $this->createForm(RestaurantsType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $brochureFile = $form->get('photo_rest')->getData();
            if ($brochureFile) {
                $brochureFileName = $imageUploader->upload($brochureFile);
                $restaurant->setPhotoRest($brochureFileName);
            } else {
                $restaurant->setPhotoRest($fileName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('restaurants_index');
        }

        return $this->render('restaurants/edit.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="restaurants_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Restaurants $restaurant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restaurant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($restaurant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('restaurants_index');
    }
    /**
     * @Route("/search", name="search_restaurant")
     */
    public function searchRestaurantx(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Restaurants::class);
        $requestString = $request->get('searchValue');
        $restaurants = $repository->findRestaurantByNom($requestString);
        $jsonContent = $Normalizer->normalize($restaurants, 'json',[]);

        return new Response(json_encode($jsonContent));
    }


}
