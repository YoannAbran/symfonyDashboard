<?php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use App\Entity\User;
use App\Entity\Book;
use App\Entity\CustomerFlow;
use App\Entity\Flow;

class MailEndRentController extends AbstractController
{
    /**
     * @Route("/mail/end/rent", name="mail_end_rent")
     */
     public function sendEmail(MailerInterface $mailer)
     {
       $em = $this->getDoctrine()->getManager();
       $date = new \DateTime('now');
       $mailDate = new \DateTime('now');
       $retunMailDate = $mailDate->add(new \DateInterval('P6D'));
       $returnDate = $date->add(new \DateInterval('P7D'));

       $flow = $em->getRepository(Flow::class)
               ->findBy(
                 ['returnDate'=> $returnDate]
               );

foreach ($flow as $value) {

  $id = $value->getId();



$customerFlow  = $em->getRepository(CustomerFlow::class)
         ->findBy(
          ['Flow'=>$id]
         );
         foreach ($customerFlow  as $value) {

           $idUser = $value->getUser();
           $idBook = $value->getBook();

// dd($idUser);
        $book = $em->getRepository(Book::class)
                ->find($idBook);
       $user = $em->getRepository(User::class)
               ->find($idUser);

         $email = (new Email())
          ->from(new Address('contact@booking.com', 'BOOKING'))
	        ->to($user->getEmail())
	        ->subject('Best practices of building HTML emails')
          ->text("Hey {$user->getUserName()} tu dois ramener ton livre {$book->getTitle()} et grouille toi !!!");



  $mailer->send($email);
  }
  }
  return $this->render('home.html.twig');
}
}
