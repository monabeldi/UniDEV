<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
use App\Repository\HotelRepository;
//use http\Env\Request;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Type;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Json;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class HotelController extends AbstractController
{
    /**
     * @Route("/hotel", name="hotel")
     */
    public function index(): Response
    {
        return $this->render('hotel/index.html.twig', [
            'controller_name' => 'HotelController',
        ]);
    }
    /**
     * @param HotelRepository $repository
     * @return \Symfony\Component\HttpFoundation\Reponse
     * @Route("hotel/AfficheH",name="AfficheH")
     */
    public function AfficheS(HotelRepository $repository){
        $Hotel=$repository->findAll();
        return $this->render('hotel/AfficheS.html.twig',['Hotel'=>$Hotel]);

    }






    /**
* @param  $request
* @return Response
* @route("hotel/Add", name="new")
*/
    function Add(\Symfony\Component\HttpFoundation\Request $request,ImageUploader $ImageUploader){
        $Hotel=new hotel();
        $form=$this->createForm(HotelType::class,$Hotel);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('photohotel')->getData();
            if ($imageFile) {
                $imageFileName = $ImageUploader->upload($imageFile);
                $Hotel->setPhotoHotel($imageFileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($Hotel);
            $em->flush();
            return $this->redirectToRoute('AfficheH');
        }
        return $this->render('hotel/Add.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @route ("/Suppp/{idhotel}",name="d")
     */

    function Delete($idhotel ,HotelRepository $repository){
        $Hotel=$repository->find($idhotel);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Hotel);
        $em->flush();
        return $this->redirectToRoute('AfficheH');

    }

//    function Delete($idhotel ,HotelRepository $repository){
//        $Hotel=$repository->find($idhotel);
//        $em=$this->getDoctrine()->getManager();
//        $em->remove($Hotel);
//        $em->flush();
//        return $this->redirectToRoute('AfficheH');
//
//    }

  /**

   * @route ("hotel/Update/{idhotel}",name="update")
 */
function Update(HotelRepository $repository,$idhotel,Request $request,ImageUploader $ImageUploader){
    $Hotel=$repository->find($idhotel);
    $form=$this->createForm(HotelType::class,$Hotel);
    $form->add('Update',SubmitType::class);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()) {
        $imageFile = $form->get('photohotel')->getData();
        if ($imageFile) {
            $imageFileName = $ImageUploader->upload($imageFile);
            $Hotel->setPhotoHotel($imageFileName);
        }
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute('AfficheH');
    }
    return $this->render('hotel/Update.html.twig',[
        'f'=>$form->createView()
    ]);

}


//public function  recherchebyid(\Symfony\Component\HttpFoundation\Request $request){
//
//
//    $em=$this->getDoctrine()->getManager();
//        $Hotel=$em->getRepository(Hotel::class)->findAll();
//        if ($request->isMethod("POST")){
//
//            $idhotel=$request->get('idhotel');
//            $Hotel==$em->getRepository("HotelBundle:Hotel")->findBy(array('idhotel'=>$idhotel),array('nomhotel'=>'ASC'));
//        }
//        return $this->render('hotel/Recherche.html.twig',array('hotel'=>$Hotel));
//}
    /**
     * @param HotelRepository $repository
     * @param Request $request
     * @return Response
     * @Route ("/search_ajax",name="search_ajax")
     */
    public function searchAction(Request $request,HotelRepository $repository)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
//         var_dump(strlen($requestString));
        $entities =  $em->getRepository(Hotel::class)->findEntitiesByString($requestString);

        if(!$entities)
        {
            $result['entities']['error'] = "there is no demande with this titre";

        }
        if(strlen($requestString)==1)
        {

            $entities=$repository->findAll();
            $result['entities']=$this->getRealEntities($entities);
        }
        else
        {

            $result['entities'] = $this->getRealEntities($entities);
        }

        return new JsonResponse($result, 200);
    }


    public function getRealEntities($entities){


        foreach ($entities as $entity)
        {
            $realEntities[$entity->getIdHotel()] = [$entity->getNomHotel(), $entity->getAdrrHotel(),$entity->getPhotoHotel(),$entity->getIdHotel(),$entity->getRateHotel(),$entity->getDescHotel(),$entity->getPrixNuit(),$entity->getNumTelHotel()];
        }


        return $realEntities;
    }

    /**
     * @param HotelRepository $hotelRepository
     * @return Response
     * @Route("/Hotels",name="AfficheQ")
     */
    public function listeHotels(HotelRepository $hotelRepository): Response
    {
        return $this->render('Hotels/listinghotel.html.twig',  [
            'Hotel' => $hotelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/json",name="hotel_json", methods={"GET"})
     */
public function AllHotel(HotelRepository $repository ,SerializerInterface $serializerInterface): Response
{



    $Hotel = $repository->findAll();

    $jsonContent = $serializerInterface->serialize($Hotel, 'json',['groups'=>'hotel']);


    return  new Response($jsonContent);


}


/**
 * @Route("/join/new",name="join_hotel")
 */
public function addhotelJson(Request $request , SerializerInterface $serializerInterface, EntityManagerInterface $em){


    $em = $this->getDoctrine()->getManager();
    $Hotel = new Hotel();
    $Hotel->setNomHotel($request->get('nomhotel'));
    $Hotel->setAdrrHotel($request->get('adrrhotel'));
    $Hotel->setPhotoHotel($request->get('photohotel'));
    $Hotel->setRateHotel($request->get('ratehotel'));
    $Hotel->setDescHotel($request->get('deschotel'));
    $Hotel->setPrixNuit($request->get('prixnuit'));
    $Hotel->setNumTelHotel($request->get('numtelhotel'));

    $em->persist($Hotel);
    $em->flush();;
    $jsonContent= $serializerInterface->serialize($Hotel,'json',['groups'=> 'hotel']  );
    return new Response(json_encode($jsonContent));


}



}
