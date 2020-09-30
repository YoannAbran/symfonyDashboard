<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BookRepository;
use App\Service\Cart\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cartService)
    {
<<<<<<< HEAD
        $panierWithData = $cartService->getFullCart();

        $total = $cartService->getTotal();

=======
      $panierRent = $session->get('panierRent', []);
      $panier = $session->get('panier', []);

        $panierAchat = [];
        $panierLocation = [];

        foreach($panier as $id => $quantity){
          $panierAchat[] = [
            'book' => $bookRepository->find($id),
            'quantity' => $quantity
          ];
        }

        foreach($panierRent as $id => $quantity){
          $panierLocation[] = [
            'book' => $bookRepository->find($id),
            'quantity' => $quantity
          ];
        }

    $total = 0;

      foreach ($panierAchat as $item) {
        $totalItem = $item['book']->getSoldPrice() * $item['quantity'];
        $total += $totalItem;
      }

      foreach ($panierLocation as $item) {
        $totalItem = $item['book']->getRentPrice() * $item['quantity'];
        $total += $totalItem;
        }


>>>>>>> 44b1bd80f4799a8c442eb57ac5cb0fdcd8982fb5
      return $this->render('cart/index.html.twig', [
      'panierAchat' => $panierAchat,
      'panierLocation' => $panierLocation,
      'total' => $total]);
    }


    /**
     * @Route("/panier/ad/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService){

      $cartService->add($id);

      return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/panier/rent/{id}", name="cart_rent")
     */
    public function rent($id, Session $session){

      $panierRent =  $session->get('panierRent', []);

      if(!empty($panierRent[$id])){
        $panierRent[$id]++;
      } else {
        $panierRent[$id] = 1;
      }

      $session->set('panierRent', $panierRent);

      return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, SessionInterface $session ){
      $panier = $session->get ('panier', []);

      if(!empty($panier[$id])){
        unset($panier[$id]);
      }

      $session->set('panier', $panier);

      return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/panier/removeRent/{id}", name="cart_removeRent")
     */
    public function removeRent($id, Session $session ){

      $panierRent = $session->get ('panierRent', []);

      if(!empty($panierRent[$id])){
        unset($panierRent[$id]);
      }

      $session->set('panierRent', $panierRent);

      return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/panier/removeAll", name="removeAll")
     */
<<<<<<< HEAD
    public function removeAll(SessionInterface $session ){
      $panier = $session->get ('panier', []);
=======
    public function removeAll(Session $session ){
>>>>>>> 44b1bd80f4799a8c442eb57ac5cb0fdcd8982fb5

      $panier = $session->get ('panier', []);
      $panierRent = $session->get ('panierRent', []);

        unset($panier);
        unset($panierRent);
      $session->set('panier', []);
      $session->set('panierRent', []);

      return $this->redirectToRoute("cart_index");
    }

}
