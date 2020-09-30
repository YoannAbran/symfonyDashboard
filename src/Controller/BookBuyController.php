<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;
use App\Entity\Book;
use App\Entity\User;
use App\Entity\CustomerFlow;
use App\Entity\Flow;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class BookBuyController extends AbstractController
{
    /**
     * @Route("/bookBuy", name="bookBuy")
     */

    public function getBuyBook(Session $session, BookRepository $bookRepository)
    {
        $em = $this->getDoctrine()->getManager();

        $panierRent = $session->get('panierRent', []);
        $panier = $session->get('panier', []);

        $panierAchat = [];
        $panierLocation = [];

        foreach ($panier as $id => $quantity) {
            $panierAchat[] = [
             'book' => $bookRepository->find($id),
             'quantity' => $quantity
           ];
        }

        foreach ($panierRent as $id => $quantity) {
            $panierLocation[] = [
             'book' => $bookRepository->find($id),
             'quantity' => $quantity
           ];
        }

        $user = $this->getUser();

        foreach ($panierAchat as $item) {
            $user = $this->getUser();
            $stock = $item['book']->getStock();
            $sold = $item['book']->getSold();
            $id = $item['book']->getId();
            $book = $em->getRepository(Book::class)
                    ->find($id);
            $quantity = $item['quantity'];

            $book->setStock($stock-$quantity);
            $book->setSold($sold+$quantity);

            $date = new \DateTime('now');
            $flow = new Flow;
            $flow->setBook($book);
            $flow->setBuyDate($date);
            $em->persist($flow);

            $customerFlow = new CustomerFlow;
            $customerFlow->setUser($user);
            $customerFlow->setBook($book);
            $customerFlow->setFlow($flow);
            $em->merge($customerFlow);
            $em->flush();
            $em->clear();
        }

        foreach ($panierLocation as $item) {
            $user = $this->getUser();

            $stock = $item['book']->getStock();
            $rent = $item['book']->getRent();
            $id = $item['book']->getId();
            $book = $em->getRepository(Book::class)
                    ->find($id);
            $quantity = $item['quantity'];

            $book->setStock($stock-$quantity);
            $book->setRent($rent+$quantity);

            $date = new \DateTime('now');
            $buyDate = new \DateTime('now');
            $returnDate = $date->add(new \DateInterval('P7D'));
            $flow = new Flow;
            $flow->setBook($book);
            $flow->setRentDate($buyDate);
            $flow->setReturnDate($returnDate);
            $em->persist($flow);

            $customerFlow = new CustomerFlow;
            $customerFlow->setUser($user);
            $customerFlow->setBook($book);
            $customerFlow->setFlow($flow);
            $em->merge($customerFlow);
            $em->flush();
            $em->clear();
        }
        return $this->redirectToRoute('removeAll');
    }
}
