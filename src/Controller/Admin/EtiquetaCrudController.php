<?php

namespace App\Controller\Admin;

use App\Entity\Etiqueta;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EtiquetaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Etiqueta::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
