<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;
use App\Entity\Book;
use App\Entity\User;
use App\Entity\CustomerFlow;
use App\Entity\Flow;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookBuyController extends AbstractController
{
    /**
     * @Route("/bookBuy/{id}", name="bookBuy")
     */

     public function getBuyBook($id)
     {
       $em = $this->getDoctrine()->getManager();
       $book = $em->getRepository(Book::class)
                  ->find($id);

              $stock = $book->getStock();
              $sold = $book->getSold();

              if ($stock>0){
                $user = $this->getUser();
                $user->getUserName();
                $getUser = $em->getRepository(User::class)
                           ->find($user);

              $book->setStock($stock-1);
              $book->setSold($sold+1);
              $em->flush();

              $date = new \DateTime('now');
              $flow = new Flow;
              $flow->setBook($book);
              $flow->setBuyDate($date);
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
  return new Response('nous sommes désolé nous n\'avons plus ce livre en stock');
}

     }


}
