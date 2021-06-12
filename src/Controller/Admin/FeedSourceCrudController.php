<?php

namespace App\Controller\Admin;

use App\Entity\FeedSource;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class FeedSourceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FeedSource::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
            UrlField::new('url'),
        ];
    }
}
