<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use App\Entity\Book;
use App\Entity\User;
use App\Entity\CustomerFlow;
use App\Entity\Flow;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookRentController extends AbstractController
{
    /**
     * @Route("/bookRent/{id}", name="bookRent")
     *
     */
     public function getBuyBook($id)
     {
       $em = $this->getDoctrine()->getManager();
       $book = $em->getRepository(Book::class)
                  ->find($id);



              $stock = $book->getStock();
              $rent = $book->getRent();

              if ($stock>0){
                $user = $this->getUser();
                $user->getUserName();
                $getUser = $em->getRepository(User::class)
                           ->find($user);

              $book->setStock($stock-1);
              $book->setRent($rent+1);
              $em->flush();

              $date = new \DateTime('now');
              $buyDate = new \DateTime('now');
              $returnDate = $date->add(new \DateInterval('P7D'));
              $flow = new Flow;
              $flow->setBook($book);
              $flow->setRentDate($buyDate);
              $flow->setReturnDate($returnDate);
              $em->persist($flow);
              $em->flush();


              $getFlow = $em->getRepository(Flow::class)
                         ->find($flow);
              $customerFlow = new CustomerFlow;
              $customerFlow->setUser($getUser);
              $customerFlow->setBook($book);
              $customerFlow->setFlow($getFlow);
              $em->persist($customerFlow);
              $em->flush();
              return $this->redirectToRoute('bookList');
              }
              else {
              return  new Response('nous sommes désolé nous n\'avons plus ce livre en stock');
              }
     }



}
