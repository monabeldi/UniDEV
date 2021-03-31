<?php

namespace App\Controller;

use App\Entity\Activities;
use App\Entity\Organisateurs;
use App\Form\OrganisateursType;
use App\Repository\OrganisateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/organisateurs")
 */
class OrganisateursController extends AbstractController
{
    /**
     * @Route("/", name="organisateurs_index", methods={"GET"})
     */
    public function index(OrganisateursRepository $organisateursRepository): Response
    {
        return $this->render('organisateurs/index.html.twig', [
            'organisateurs' => $organisateursRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="organisateurs_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $organisateur = new Organisateurs();
        $form = $this->createForm(OrganisateursType::class, $organisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($organisateur);
            $entityManager->flush();

            return $this->redirectToRoute('organisateurs_index');
        }

        return $this->render('organisateurs/new.html.twig', [
            'organisateur' => $organisateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="organisateurs_show", methods={"GET"})
     */
    public function show(Organisateurs $organisateur): Response
    {
        return $this->render('organisateurs/show.html.twig', [
            'organisateur' => $organisateur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="organisateurs_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Organisateurs $organisateur): Response
    {
        $form = $this->createForm(OrganisateursType::class, $organisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('organisateurs_index');
        }

        return $this->render('organisateurs/edit.html.twig', [
            'organisateur' => $organisateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="organisateurs_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Organisateurs $organisateur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$organisateur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($organisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('organisateurs_index');
    }

    /**
     * @Route("/search", name="search_organisateurs", requirements={"id":"\d+"})
     * @param Request $request
     * @param NormalizerInterface $Normalizer
     * @return Response
     * @throws ExceptionInterface
     */
    public function searchOrganisateurs(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Organisateurs::class);
        $requestString = $request->get('searchValue');
        $guides = $repository->findOrganisateursByNom($requestString);
        $jsonContent = $Normalizer->normalize($guides, 'json',[]);

        return new Response(json_encode($jsonContent));
    }
}
