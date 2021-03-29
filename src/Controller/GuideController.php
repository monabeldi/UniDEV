<?php

namespace App\Controller;

use App\Entity\Guides;
use App\Repository\GuidesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class GuideController extends AbstractController
{
    /**
     * @Route("/guide", name="guide")
     * @Template("guide/guide.html.twig")
     * @param GuidesRepository $guidesRepository
     * @return array
     */
    public function index(GuidesRepository $guidesRepository): array
    {
        return ['guides' => $guidesRepository->findAll()];
    }

    /**
     * @Route("/{id}", name="guide_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Guides $guide): Response
    {
        return $this->render('guide/show.html.twig', [
            'guide' => $guide,
        ]);
    }



}
