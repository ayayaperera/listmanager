<?php

namespace App\Controller\Admin;

use App\Entity\Lista;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ListaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lista::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nombre'),
            DateField::new('fecha'),
            AssociationField::new('etiqueta'),
        ];
    }
    
}
