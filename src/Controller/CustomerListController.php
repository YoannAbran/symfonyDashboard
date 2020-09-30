<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\User;
use App\Entity\CustomerFlow;
use App\Entity\Flow;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CustomerListController extends AbstractController
{
    /**
     * @Route("/customerList", name="customerList")
     */
    public function getCustomerList()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->getUserName();
        $getUser = $em->getRepository(User::class)
                 ->find($user);
        $userId = $getUser->getId();
        $customerFlows =$em->getRepository(CustomerFlow::class)
                 ->findBy(['user'=>$userId]);
        // $customerFlow=array();


        return $this->render('customerList/index.html.twig', ['customerFlows'=>$customerFlows]);
    }
}
