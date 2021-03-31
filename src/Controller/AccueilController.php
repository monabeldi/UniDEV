<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BoutiqueRepository;
use App\Repository\ProduitRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
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
     * @Route("/restaurant", name="restaurant")
     */
    public function restaurant(): Response
    {
        return $this->render('restaurant/restaurant.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
    /**
     * @Route("/admin", name="admin")
     * Require ROLE_ADMIN for *every* controller method in this class.
     *
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin(): Response
    {
        return $this->render('admin/admin.html.twig', [
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

    /**
     * @Route("/add", name="addrestaurant")
     */
    public function addrestaurant(): Response
    {
        return $this->render('restaurant/add.restaurant.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }



    /**
     * @Route("/Produits", name="Produits")
     */
    public function produits(): Response
    {
        return $this->render('produits/produits.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    /**
     * @Route("/listeProduits", name="listeProduits")
     * @param $produitRepository
     * @return Response
     */
    public function listeproduits(ProduitRepository $produitRepository): Response
    {
        return $this->render('produits/listeproduits.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/listeBoutiques", name="listeBoutiques")
     * @param $boutiqueRepository
     * @return Response
     */
    public function listeboutiques(BoutiqueRepository $boutiqueRepository): Response
    {
        return $this->render('boutiques/listingBoutiques.html.twig', [
            'boutiques' => $boutiqueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/addBoutiques", name="addboutiques")
     */
    public function addboutiques(): Response
    {
        return $this->render('boutiques/addboutiques.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    /**
     * @Route("/addProduit", name="addProduit")
     */
    public function addProduit(): Response
    {
        return $this->render('produit/new.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    /**
     * @Route("/profile", name="profile",)
     */
    public function profile(): Response
    {
        return $this->render('profile/profile/new.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }






}
