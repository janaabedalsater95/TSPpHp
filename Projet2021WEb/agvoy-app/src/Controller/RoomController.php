<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Room;
use App\Entity\Owner;

class RoomController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('room/index.html.twig', [
            'controller_name' => 'RoomController',
        ]);
    }
    
    /**
     * Lists all rooms 
     *
     * @Route("/list", name = "room_list", methods="GET")
     * @Route("/index", name="room_index", methods="GET")
     */
    public function listAction()
    {
      
        $em = $this->getDoctrine()->getManager();
        $rooms = $em->getRepository(Room::class)->findAll();
        
        return $this->render('room/ListRooms.html.twig',
            [ 'rooms' => $rooms ]
            );
        
        
    }
    
    
    /**
     * Finds and displays a todo entity.
     *
     * @Route("/{id}", name="room_show", requirements={ "id": "\d+"}, methods="GET")
     */
    public function showAction(Room $room): Response
    {
        return $this->render('room/showRoom.html.twig',
            [ 'room' => $room]
            );
    }
    
    
}
