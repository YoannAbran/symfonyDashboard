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

        foreach($panierRent as $id => $quantityRent){
          $panierLocation[] = [
            'book' => $bookRepository->find($id),
            'quantityRent' => $quantityRent
          ];
        }

    $total = 0;

      foreach ($panierAchat as $item) {
        $totalItem = $item['book']->getSoldPrice() * $item['quantity'];
        $total += $totalItem;
      }

      foreach ($panierLocation as $item) {
        $totalItem = $item['book']->getRentPrice() * $item['quantityRent'];
        $total += $totalItem;
        }


      return $this->render('cart/index.html.twig', [
      'panierAchat' => $panierAchat,
      'panierLocation' => $panierLocation,
      'total' => $total]);
    }


    /**
     * @Route("/panier/ad/{id}", name="cart_add")
     */
    public function add($id, Session $session, BookRepository $bookRepository){

      $em = $this->getDoctrine()->getManager();
      $panier =  $session->get('panier', []);


      if(!empty($panier[$id])){
        $panier[$id]++;
      } else {
        $panier[$id] = 1;
      }

        $stock = $bookRepository->find($id)->getStock();

        $bookRepository->find($id)->setStock($stock-1);
        $em->flush();


      $session->set('panier', $panier);

      return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/panier/rent/{id}", name="cart_rent")
     */
    public function rent($id, Session $session,BookRepository $bookRepository){

      $em = $this->getDoctrine()->getManager();
      $panierRent =  $session->get('panierRent', []);

      if(!empty($panierRent[$id])){
        $panierRent[$id]++;
      } else {
        $panierRent[$id] = 1;
      }

      $stock = $bookRepository->find($id)->getStock();

      $bookRepository->find($id)->setStock($stock-1);
      $em->flush();
      $session->set('panierRent', $panierRent);

      return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/panier/rentRemove/{id}", name="rent_remove")
     */
    public function RentRemove($id, Session $session ,BookRepository $bookRepository){

      $em = $this->getDoctrine()->getManager();
      $panierRent =  $session->get('panierRent', []);

      if(!empty($panierRent[$id])){
        $panierRent[$id]--;
      } else {
        $panierRent[$id] = 1;
      }

      if(!empty($panierRent[$id])){
      } else {
      unset($panierRent[$id]);
      }

      $stock = $bookRepository->find($id)->getStock();

      $bookRepository->find($id)->setStock($stock+1);
      $em->flush();
      $session->set('panierRent', $panierRent);

      return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/panier/adRemove/{id}", name="add_remove")
     */
    public function AddRemove($id, Session $session,BookRepository $bookRepository){

      $em = $this->getDoctrine()->getManager();
      $panier =  $session->get('panier', []);

      if(!empty($panier[$id])){
        $panier[$id]--;
      } else {
        $panier[$id] = 1;
      }

      if(!empty($panier[$id])){
      } else {
      unset($panier[$id]);
      }

      $stock = $bookRepository->find($id)->getStock();

      $bookRepository->find($id)->setStock($stock+1);
      $em->flush();
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
    public function removeAll(Session $session ){

      $panier = $session->get ('panier', []);
      $panierRent = $session->get ('panierRent', []);

        unset($panier);
        unset($panierRent);
      $session->set('panier', []);
      $session->set('panierRent', []);

      return $this->redirectToRoute("cart_index");
    }

}
