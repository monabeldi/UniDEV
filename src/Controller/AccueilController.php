<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(): Response
    {
        return $this->render('accueil/index.html', [
            'controller_name' => 'AccueilController',
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('about/about.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('contact/contact.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }


    /**
     * @Route("/listing", name="listing")
     */
    public function listing(): Response
    {
        return $this->render('listing/listing.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }



    /**
     * @Route("/listing-details", name="listing-details")
     */
    public function listingdetails(): Response
    {
        return $this->render('listing/listing-details/listing-details.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }


}
