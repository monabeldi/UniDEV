<?php

namespace App\Controller;

use App\Entity\Uber;
use App\Form\UberType;
use App\Repository\UberRepository;
use App\Service\ImageUploader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/uber")
 */
class UberController extends AbstractController
{
    /**
     * @Route("/", name="uber_index", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Uber::class)->findAll();

        $ubers = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            2
        );

        return $this->render('uber/index.html.twig', [
            'ubers' => $ubers,
        ]);
    }
    /**
     * @Route("/search", name="search_uber")
     * @IsGranted("ROLE_ADMIN")
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
     * @IsGranted("ROLE_ADMIN")
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
     * @IsGranted("ROLE_ADMIN")
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
     * @return Response
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Uber $uber, ImageUploader $imageUploader): Response
    {
        $fileName = $uber->getPhotoUber();
        $uber->setPhotoUber(
            new File($this->getParameter('images_directory').'/'.$uber->getPhotoUber())
        );
        $form = $this->createForm(UberType::class, $uber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $brochureFile = $form->get('photo_uber')->getData();
            if ($brochureFile) {
                $brochureFileName = $imageUploader->upload($brochureFile);
                $uber->setPhotoUber($brochureFileName);
            } else {
                $uber->setPhotoUber($fileName);
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
     * @Route("/{id}", name="uber_delete", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
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

    /**
     * @Route("/list/json", name="uber_json", methods={"GET"})
     */
    public function uberjson(UberRepository $uberRepository,SerializerInterface $serializerInterface  ):response
    {
        $uber = $uberRepository->findAll();
        $jsonContent= $serializerInterface->serialize($uber,'json',['groups'=> 'uber']  );
        return new Response($jsonContent);
    }

    /**
     * @Route("/addUber/new", name="add_uber", methods={"GET","POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws ExceptionInterface
     */

        public function addUberAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $uber = new Uber();
        $uber->setNomUber($request->get("nom_uber"));
        $uber->setNumTelUber($request->get("num_tel_uber"));
        $uber->setFieldUber($request->get("field_uber"));
        $uber->setPrixUber($request->get("prix_uber"));
        $uber->setPhotoUber($request->get("photo_uber"));
        $em->persist($uber);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($uber);
        return new JsonResponse($formatted);

}

}
