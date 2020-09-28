<?php

namespace App\Controller;

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
        return $this->render('admin/dashboard.html.twig');
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
      return $this->render('books.html.twig', [
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
        return $this->render('book.html.twig', ['book' => $book]);
        }

}
