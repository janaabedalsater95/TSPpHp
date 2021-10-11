<?php

namespace App\Controller;

use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\RoomType;
use App\Entity\Region;

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
    
    /**
     * @Route("/new", name="room_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $room= new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Change content-type according to image's
            $imagefile = $room->getImageFile();
            if($imagefile) {
                $mimetype = $imagefile->getMimeType();
                $room->setContentType($mimetype);
            }
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($room);
            $entityManager->flush();
        }
        
        return $this->render('room/new.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/{id}/edit", name="room_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Room $room): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('room_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('room/edit.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/{id}", name="room_delete", methods={"POST"})
     */
    public function delete(Request $request, Room $room): Response
    {
        if ($this->isCsrfTokenValid('delete'.$room->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($room);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('room_index', [], Response::HTTP_SEE_OTHER);
    }
    
    /**
     * Mark a task as current priority in the user's session
     *
     * @Route("/mark/{id}", name="room_mark", requirements={ "id": "\d+"}, methods="GET")
     */
    public function markAction(Room $room): Response
    {
        dump($room);
        // si l'identifiant n'est pas présent dans le tableau des urgents, l'ajouter
        $id= $room->getId();
        $urgents = array();
        if (! in_array($id, $urgents) )
        {
            $urgents[] = $id;
            $this->get('session')->set('urgents', $urgents);
        }
        else
        // sinon, le retirer du tableau
        {
            $urgents = array_diff($urgents, array($id));
            $urgents = $this->get('session')->get('urgents');
        }
        return $this->redirectToRoute('room_show',
            ['id' => $room->getId()]);
    }
    
}
