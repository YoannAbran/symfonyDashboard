<?php

namespace App\Controller;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextField::new('ref'),
            TextEditorField::new('description'),
            TextField::new('category'),
            MoneyField::new('buyPrice')->setCurrency('EUR'),
            MoneyField::new('soldPrice')->setCurrency('EUR'),
            MoneyField::new('rentPrice')->setCurrency('EUR'),

            ImageField::new('photoFile')->hideOnIndex(),
            ImageField::new('photo')
            ->setBasePath('/img/photo')
            ->hideOnForm(),
            IntegerField::new('stock'),
            IntegerField::new('sold'),
            IntegerField::new('rent'),

        ];
    }

}
