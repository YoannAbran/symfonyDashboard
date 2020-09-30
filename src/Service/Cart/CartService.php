<?php

namespace App\Service\Cart;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService{

  protected $session;

  public function __construct(SessionInterface $session, BookRepository $bookRepository){
    $this->session = $session;
    $this->BookRepository = $bookRepository;
  }

  public function add(int $id){
    $panier =  $this->session->get('panier', []);

    if(!empty($panier[$id])){
      $panier[$id]++;
    } else {
      $panier[$id] = 1;
    }

    $this->session->set('panier', $panier);
}

  public function remove(int $id){


  }

  public function getFullCart() : array {
    $panier = $this->session->get('panier', []);

    $panierWithData = [];

    foreach($panier as $id => $quantity){
      $panierWithData[] = [
        'book' => $this->BookRepository->find($id),
        'quantity' => $quantity
      ];
    }

    return $panierWithData;
  }

  public function getTotal() : float {

    $total = 0;

if  (isset($_GET['action'])) {
foreach ($this->getFullCart() as $item) {
    if ($_GET['action'] == 'achat') {
    $total += $item['book']->getSoldPrice() * $item['quantity'];

      if ($_GET['action'] == 'location') {
        $total += $item['book']->getRentPrice() * $item['quantity'];
          }
        }
      }
    }

  return $total;
  }
}
