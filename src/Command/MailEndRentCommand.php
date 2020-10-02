<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\User;
use App\Entity\Book;
use App\Entity\CustomerFlow;
use App\Entity\Flow;

class MailEndRentCommand extends Command
{
  protected static $defaultName = 'app:send-mail';
  private $mail;

  public function __construct(MailerInterface $mail, ContainerInterface $container, EntityManagerInterface $em)
  	{
  		parent::__construct();

  		$this->mail = $mail;
      $this->container = $container;
  		$this->em = $em;
  	}

     protected function execute(InputInterface $input, OutputInterface $output)
     {
       $em = $this->container->get('doctrine')->getManager();
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



  $this->mail->send($email);
  $output->writeln('Successful you send a self email');
  }
  }
return Command::SUCCESS;
}
}
