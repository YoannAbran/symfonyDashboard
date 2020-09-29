<?php

namespace App\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use App\Repository\BookRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use App\Entity\Book;
use App\Entity\User;




class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
      $buyPrices = $this->getDoctrine()
                        ->getRepository(Book::class)
                        ->getSumBuyPrice();
      $soldPrices = $this->getDoctrine()
                        ->getRepository(Book::class)
                        ->getSumSoldPrice();
      $rentPrices = $this->getDoctrine()
                        ->getRepository(Book::class)
                        ->getSumRentPrice();

//chart pie buy price categorie
      $data = [['Category','Prix']];
      foreach ($buyPrices as $buyPrice) {
        $data[] = array($buyPrice['category'],$buyPrice['buyP']*$buyPrice['stock']);
      }
      $pieChart = new PieChart();
      $pieChart->getOptions()->setTitle('Prix des livres acheter par categorie');
      $pieChart->getOptions()->setHeight(500);
      $pieChart->getOptions()->setWidth(600);
      $pieChart->getOptions()->setBackgroundColor('transparent');
      $pieChart->getData()->setArrayToDataTable($data);



      //pie chart rent by categorie
      $dataRent = [['Category','location']];
      foreach ($rentPrices as $rentPrice) {
        $dataRent[] = array($rentPrice['category'],(int)$rentPrice['rentL']);
      }
      $pieRentChart = new PieChart();
      $pieRentChart->getOptions()->setTitle('Livres louer par categorie');
      $pieRentChart->getOptions()->setHeight(500);
      $pieRentChart->getOptions()->setWidth(600);
      $pieRentChart->getOptions()->setBackgroundColor('transparent');
      $pieRentChart->getData()->setArrayToDataTable($dataRent);


      //bar chart sold by categorie
      $dataBar = [['Category','Prix']];
      foreach ($soldPrices as $soldPrice) {
        $dataBar[] = array($soldPrice['category'],$soldPrice['soldP']*$soldPrice['sold']);
      }
      $barChart = new BarChart();
      $barChart->getOptions()->setTitle('Prix des livres vendus par categorie');
      $barChart->getOptions()->setHeight(500);
      $barChart->getOptions()->setWidth(800);
      $barChart->getOptions()->setBackgroundColor('transparent');
      $barChart->getData()->setArrayToDataTable($dataBar);


        return $this->render('admin/dashboard.html.twig',array('piechart' => $pieChart,'barchart'=>$barChart,'pierentchart'=>$pieRentChart));
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SymfonyDashboard');
    }


    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Livres', 'icon class', Book::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'icon class', User::class);
        // yield MenuItem::linkToRoute('Register', 'icon class', 'app_register'); // Inutile car lien déjà présent sur le navBar
        yield MenuItem::linkToRoute('Retour accueil', 'icon class', 'home');
    }


    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/books", name="books")
     */
    public function books()
    {
      $repo = $this->getDoctrine()->getRepository(Book::class);
      $books = $repo->findAll();
      return $this->render('booksList/books.html.twig', [
          'books' => $books
      ]);
    }

    /**
     * @Route("/books/{id}", name="book")
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Book::class);
        $book = $repo->find($id);
        return $this->render('booksList/book.html.twig', ['book' => $book]);
        }





}
