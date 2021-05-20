<?php

namespace App\Controller;

use App\Entity\Guides;
use App\Form\GuidesType;
use App\Repository\GuidesRepository;
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
 * @Route("/guides")
 *
 *
 */

class GuidesController extends AbstractController
{
    /**
     * @Route("/", name="guides_index")
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Guides::class)->findAll();

        $guides = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            2
        );

        return $this->render('guides/index.html.twig', [
            'guides' => $guides,
        ]);

    }


    /**
     * @Route("/new", name="guides_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $guide = new Guides();
        $form = $this->createForm(GuidesType::class, $guide);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $guide->getPhotoGui();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e){
            }
            $entityManager = $this->getDoctrine()->getManager();
            $guide->setPhotoGui($fileName);
            $entityManager->persist($guide);
            $entityManager->flush();

            return $this->redirectToRoute('guides_index');
        }

        return $this->render('guides/new.html.twig', [
            'guide' => $guide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="guides_show", methods={"GET"}, requirements={"id"="\d+"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(Guides $guide): Response
    {
        return $this->render('guides/show.html.twig', [
            'guide' => $guide,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="guides_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Guides $guide): Response
    {
        $form = $this->createForm(GuidesType::class, $guide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploaded_file = $form['photo_gui']->getData();
            if ($uploaded_file) {
                $image = GuidesType::processImage($uploaded_file);
                $guide->setPhotoGui($image);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('guides_index');
        }

        return $this->render('guides/edit.html.twig', [
            'guide' => $guide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="guides_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Guides $guide): Response
    {
        if ($this->isCsrfTokenValid('delete'.$guide->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($guide);
            $entityManager->flush();
        }

        return $this->redirectToRoute('guides_index');
    }

    /**
     * @Route("/search", name="search_guides", requirements={"id":"\d+"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function searchGuides(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Guides::class);
        $requestString = $request->get('searchValue');
        $guides = $repository->findGuidesByNom($requestString);
        $jsonContent = $Normalizer->normalize($guides, 'json',[]);

        return new Response(json_encode($jsonContent));
    }
    /**
     * @Route("/json", name="guides_json", methods={"GET"})
     */
    public function guidesjson(GuidesRepository $guidesRepository,SerializerInterface $serializerInterface  ):response
    {
        $guides = $guidesRepository->findAll();
        $jsonContent= $serializerInterface->serialize($guides,'json',['groups'=> 'guide']  );
        return new Response($jsonContent);
    }



    /**
     * @Route("/addGuide/new", name="add_Guide", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     * @throws ExceptionInterface
     */

    public function addGuideAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $guide = new Guides();
        $guide->setNomGui($request->get("nom_gui"));
        $guide->setPrenomGui($request->get("prenom_gui"));
        $guide->setEtatGui($request->get("etat_gui"));
        $guide->setDescGui($request->get("desc_gui"));
        $guide->setNumTelGui($request->get("num_tel_gui"));
        $guide->setPhotoGui($request->get("photo_gui"));
        $em->persist($guide);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($guide);
        return new JsonResponse($formatted);

    }

    /******************Supprimer Reclamation*****************************************/

    /**
     * @Route("/deleteGuide", name="delete_guide", methods={"DELETE"})
     *
     */

    public function deleteGuideAction(Request $request) {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $guide = $em->getRepository(Guides::class)->find($id);
        if($guide!=null ) {
            $em->remove($guide);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Guide a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id Guide invalide.");


    }

    /******************Modifier Reclamation*****************************************/
    /**
     * @Route("/updateGuide", name="update_guide", methods={"PUT"})
     *
     */
    public function modifierGuideAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $guide = $this->getDoctrine()->getManager()
            ->getRepository(Guides::class)
            ->find($request->get("id"));

        $guide->setNomGui($request->get("nom_gui"));
        $guide->setPrenomGui($request->get("prenom_gui"));
        $guide->setEtatGui($request->get("etat_gui"));
        $guide->setDescGui($request->get("desc_gui"));
        $guide->setNumTelGui($request->get("num_tel_gui"));

        $em->persist($guide);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($guide);
        return new JsonResponse("Guide a ete modifiee avec success.");

    }

}
