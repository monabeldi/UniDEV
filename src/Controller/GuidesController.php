<?php

namespace App\Controller;

use App\Entity\Guides;
use App\Form\GuidesType;
use App\Repository\GuidesRepository;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/guides")
 */
class GuidesController extends AbstractController
{
    /**
     * @Route("/", name="guides_index")
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
            5
        );

        return $this->render('guides/index.html.twig', [
            'guides' => $guides,
        ]);

    }


    /**
     * @Route("/new", name="guides_new", methods={"GET","POST"})
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
     */
    public function show(Guides $guide): Response
    {
        return $this->render('guides/show.html.twig', [
            'guide' => $guide,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="guides_edit", methods={"GET","POST"})
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
     */
    public function searchGuides(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Guides::class);
        $requestString = $request->get('searchValue');
        $guides = $repository->findGuidesByNom($requestString);
        $jsonContent = $Normalizer->normalize($guides, 'json',[]);

        return new Response(json_encode($jsonContent));
    }


}
