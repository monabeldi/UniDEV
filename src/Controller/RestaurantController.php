<?php

namespace App\Controller;

use App\Repository\RestaurantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RestaurantController extends AbstractController
{
    /**
     * @Route("/restaurant", name="restaurant")
     * @Template("restaurant/restaurant.html.twig")
     */
    public function index(RestaurantsRepository $restaurantsRepository): array
    {
        return [ 'restaurants' => $restaurantsRepository->findAll()];
    }
}
