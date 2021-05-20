<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Form\RestaurantsType;
use App\Repository\RestaurantsRepository;
use App\Service\ImageUploader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/restaurants")
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 *
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
     * @Route("/json", name="restaurants_json", methods={"GET"})
     */
    public function restaurantjson(RestaurantsRepository $restaurantsRepository,SerializerInterface $serializerInterface  ):response
    {
        $restaurants = $restaurantsRepository->findAll();
        $jsonContent= $serializerInterface->serialize($restaurants,'json',['groups'=> 'restaurant']  );
        return new Response($jsonContent);
    }

    /**
     * @Route("/{id}", name="restaurants_json_id", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function restaurantjsonId(Request $request,$id,SerializerInterface $serializerInterface  )
    {
        $entityManager = $this->getDoctrine()->getManager();
        $restaurants = $entityManager->getRepository(Restaurants::class)->find($id);
        $jsonContent= $serializerInterface->serialize($restaurants,'json',['groups'=> 'restaurant']  );
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/addRestaurantJSON/new", name="add_restaurants_json", methods={"GET"})
     */
    public function addrestaurantJSON(Request $request,SerializerInterface $serializerInterface  )
    {
        $entityManager = $this->getDoctrine()->getManager();
        $restaurant = new Restaurants();
        $restaurant->setNomRest($request->get('nom_rest'));
        $restaurant->setAddRest($request->get('add_rest'));
        $restaurant->setNumTelRest($request->get('num_tel_rest'));
        $restaurant->setPhotoRest($request->get('photo_rest'));
        $entityManager->persist($restaurant);
        $entityManager->flush();;
        $jsonContent= $serializerInterface->serialize($restaurant,'json',['groups'=> 'restaurant']  );
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/updateRestaurantJSON/{id}", name="update_restaurants_json", methods={"GET"})
     */
    public function updaterestaurantJSON(Request $request,SerializerInterface $serializerInterface,$id  )
    {
        $entityManager = $this->getDoctrine()->getManager();
        $restaurant = $entityManager->getRepository(Restaurants::class)->find($id);
        $restaurant->setNomRest($request->get('nom_rest'));
        $restaurant->setAddRest($request->get('add_rest'));
        $restaurant->setNumTelRest($request->get('num_tel_rest'));
        $restaurant->setPhotoRest($request->get('photo_rest'));
        $entityManager->flush();;
        $jsonContent= $serializerInterface->serialize($restaurant,'json',['groups'=> 'restaurant']  );
        return new Response("Information updated successufuly".json_encode($jsonContent));
    }

    /**
     * @Route("/deleteRestaurantJSON/{id}", name="delete_restaurants_json", methods={"GET"})
     */
    public function deleterestaurantJSON(Request $request,SerializerInterface $serializerInterface,$id  )
    {
        $entityManager = $this->getDoctrine()->getManager();
        $restaurant = $entityManager->getRepository(Restaurants::class)->find($id);
        $entityManager->remove($restaurant);
        $entityManager->flush();;
        $jsonContent= $serializerInterface->serialize($restaurant,'json',['groups'=> 'restaurant']  );
        return new Response("Restaurant deleted successufuly".json_encode($jsonContent));
    }

    /**
     * @Route("upload/new", name="upload_img", methods={"GET","POST"})
     */
    public function Upload(Request $request, ImageUploader $imageUploader,SerializerInterface $serializerInterface){
        $restaurant = new Restaurants();
        $uploadedFile = $request->files->get('photo_rest');
       // $imageFile = $form->get('photo_rest')->getData();
            if ($uploadedFile) {
                $imageFileName = $imageUploader->upload($uploadedFile);
                $restaurant->setPhotoRest($imageFileName);
            }

        $jsonContent= $serializerInterface->serialize($restaurant,'json',['groups'=> 'restaurant']  );
        return new Response("Photo added successufuly".json_encode($jsonContent));
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
