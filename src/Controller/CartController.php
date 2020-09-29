<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Repository\BookRepository;
use Symfony\Component\Routing\Annotation\Route;


class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(Session $session, BookRepository $bookRepository)
    {
        $panier = $session->get('panier', []);

        $panierWithData = [];

        foreach($panier as $id => $quantity){
          $panierWithData[] = [
            'book' => $bookRepository->find($id),
            'quantity' => $quantity
          ];
        }

    $total = 0;

  if  (isset($_GET['action'])) {
    if ($_GET['action'] == 'achat') {
      foreach ($panierWithData as $item) {
        $totalItem = $item['book']->getSoldPrice() * $item['quantity'];
        $total += $totalItem;
      }
    }

  else if ($_GET['action'] == 'location') {
      foreach ($panierWithData as $item) {
        $totalItem = $item['book']->getRentPrice() * $item['quantity'];
        $total += $totalItem;
        }
      }

      }
      return $this->render('cart/index.html.twig', [
      'panierWithData' => $panierWithData,
      'total' => $total]);
    }


    /**
     * @Route("/panier/ad/{id}", name="cart_add")
     */
    public function add($id, Session $session){

      $panier =  $session->get('panier', []);

      if(!empty($panier[$id])){
        $panier[$id]++;
      } else {
        $panier[$id] = 1;
      }

      $session->set('panier', $panier);

      return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, Session $session ){
      $panier = $session->get ('panier', []);

      if(!empty($panier[$id])){
        unset($panier[$id]);
      }

      $session->set('panier', $panier);

      return $this->redirectToRoute("cart_index");
    }

}
