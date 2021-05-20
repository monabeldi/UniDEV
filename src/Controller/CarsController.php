<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Form\CarsType;
use App\Repository\CarsRepository;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/cars")
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 *@IsGranted("ROLE_ADMIN")
 */

class CarsController extends AbstractController
{
    /**
     * @Route("/", name="cars_index", methods={"GET","POST"})
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Cars::class)->findAll();

        $cars = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            2
        );

        return $this->render('cars/index.html.twig', [
            'cars' => $cars,
        ]);
    }
    /**
     * @Route("/search", name="search_car")
     */
    public function searchCarx(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Cars::class);
        $requestString = $request->get('searchValue');
        $cars = $repository->findCarByMarque($requestString);
        $jsonContent = $Normalizer->normalize($cars, 'json',[]);

        return new Response(json_encode($jsonContent));
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

            $imageFile = $form->get('photos_car')->getData();
            if ($imageFile) {
                $imageFileName = $imageUploader->upload($imageFile);
                $car->setPhotosCar($imageFileName);
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
     * @Route("/{id}", name="cars_delete", methods={"GET","POST"}, requirements={"id"="\d+"})
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
    /**
     * @Route("/liste/json", name="cars_json", methods={"GET"})
     */
    public function carsjson(CarsRepository $carsRepository, SerializerInterface $serializerInterface  ):response
    {
        $uber = $carsRepository->findAll();
        $jsonContent= $serializerInterface->serialize($uber,'json',['groups'=> 'cars']  );
        return new Response($jsonContent);
    }
    /**
     * @Route("/addcars/new", name="add_cars", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     * @throws ExceptionInterface
     */

    public function addCarsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cars = new Cars();
        $cars->setMarqueCar($request->get("marque_car"));
        $cars->setOwnerTel($request->get("owner_tel"));
        $cars->setAddressCar($request->get("address_car"));
        $cars->setPriceCar($request->get("price_car"));
        $cars->setPhotosCar($request->get("photos_car"));
        $em->persist($cars);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($cars);
        return new JsonResponse($formatted);

    }
}
