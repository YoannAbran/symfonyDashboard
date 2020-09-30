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
        $panierWithData = $cartService->getFullCart();

        $total = $cartService->getTotal();

      return $this->render('cart/index.html.twig', [
      'panierWithData' => $panierWithData,
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
     * @Route("/panier/removeAll", name="removeAll")
     */
    public function removeAll(SessionInterface $session ){
      $panier = $session->get ('panier', []);


        unset($panier);

      $session->set('panier', []);



      return $this->redirectToRoute("cart_index");
    }

}
