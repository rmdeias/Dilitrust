<?php

namespace App\Controller\Admin;

use App\Entity\Document;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class DocumentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Document::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $documentDetail = Action::new('document_detail')
            ->linkToCrudAction('documentDetail');
                return $actions->add(Crud::PAGE_INDEX, $documentDetail);

    }

    public function configureFields(string $pageName): iterable
    {
        if ($pageName === Crud::PAGE_INDEX) {
            yield TextField::new('image')
                ->setLabel('Name');
       } else {
            yield TextField::new('imageFile')
                ->setFormType(VichImageType::class);

       }
        yield ImageField::new('image')
            ->setBasePath('uploads/product/images')
            ->setUploadDir('public/uploads/product/images')
            ->onlyOnIndex();
        yield DateTimeField::new('LastModification')
            ->hideOnForm();

    }

    public function documentDetail(Request $request, AdminContext $context): Response
    {

        $document = $context->getEntity()->getInstance();

       if(!strpos(strtolower($document->getImage()),'png') && !strpos(strtolower($document->getImage()),'jpg') && !strpos(strtolower($document->getImage()),'jpeg') && !strpos(strtolower($document->getImage()),'gif') && !strpos(strtolower($document->getImage()),'pdf')){

        return $this->render('admin/document_detail.html.twig',[
        'document' =>  file('uploads/product/images/'.$document->getImage(),FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)
        ]);
       }else {
           return $this->render('admin/index.html.twig');
       }

    }
}
