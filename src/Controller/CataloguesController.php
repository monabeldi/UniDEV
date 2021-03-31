<?php

namespace App\Controller;

use App\Entity\Catalogues;
use App\Form\CataloguesType;
use App\Repository\CataloguesRepository;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/catalogues")
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_ADMIN")
 */
class CataloguesController extends AbstractController
{
    /**
     * @Route("/", name="catalogues_index", methods={"GET"})
     */
    public function index(CataloguesRepository $cataloguesRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Catalogues::class)->findALL();
        $catalogues = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1)
        );
        return $this->render('catalogues/index.html.twig', [
            'catalogues' => $catalogues,
        ]);
    }

    /**
     * @Route("/new", name="catalogues_new", methods={"GET","POST"})
     */
    public function new(Request $request,ImageUploader $imageUploader): Response
    {
        $catalogue = new Catalogues();
        $form = $this->createForm(CataloguesType::class, $catalogue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('photo_cata')->getData();
            if ($imageFile) {
                $imageFileName = $imageUploader->upload($imageFile);
                $catalogue->setPhotoCata($imageFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($catalogue);
            $entityManager->flush();

            return $this->redirectToRoute('catalogues_index');
        }

        return $this->render('catalogues/new.html.twig', [
            'catalogue' => $catalogue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="catalogues_show", methods={"GET"},requirements={"id"="\d+"})
     */
    public function show(Catalogues $catalogue): Response
    {
        return $this->render('catalogues/show.html.twig', [
            'catalogue' => $catalogue,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="catalogues_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Catalogues $catalogue, ImageUploader $imageUploader): Response
    {
        $fileName = $catalogue->getPhotoCata();
        $catalogue->setPhotoCata(
            new File($this->getParameter('images_directory').'/'.$catalogue->getPhotoCata())
        );
        $form = $this->createForm(CataloguesType::class, $catalogue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $brochureFile = $form->get('photo_cata')->getData();
            if ($brochureFile) {
                $brochureFileName = $imageUploader->upload($brochureFile);
                $catalogue->setPhotoCata($brochureFileName);
            } else {
                $catalogue->setPhotoCata($fileName);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('catalogues_index');
        }

        return $this->render('catalogues/edit.html.twig', [
            'catalogue' => $catalogue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="catalogues_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Catalogues $catalogue): Response
    {
        if ($this->isCsrfTokenValid('delete'.$catalogue->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($catalogue);
            $entityManager->flush();
        }

        return $this->redirectToRoute('catalogues_index');
    }
    /**
     * @Route("/search_catalogue", name="search_catalogue")
     */
    public function searchcatalogue(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Catalogues::class);
        $requestString = $request->get('searchValue');
        $catalogues = $repository->findCatalogueByNom($requestString);
        $jsonContent = $Normalizer->normalize($catalogues, 'json',[]);

        return new Response(json_encode($jsonContent));
    }

}
