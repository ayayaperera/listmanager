<?php

namespace App\Controller\Admin;

use App\Entity\Checkbox;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CheckboxCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Checkbox::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nombre'),
            TextEditorField::new('info'),
            BooleanField::new('estado'),
            AssociationField::new('lista'),
        ];
    }
    
}
