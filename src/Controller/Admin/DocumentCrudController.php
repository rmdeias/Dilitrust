<?php

namespace App\Controller\Admin;

use App\Entity\Document;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Doctrine\ORM\QueryBuilder;

class DocumentCrudController extends AbstractCrudController
{
    /**
     * @return string
     */
    public static function getEntityFqcn(): string
    {
        return Document::class;
    }

    /**
     * @param SearchDto $searchDto
     * @param EntityDto $entityDto
     * @param FieldCollection $fields
     * @param FilterCollection $filters
     * @return QueryBuilder
     */
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        if(!in_array('ROLE_ADMIN',  $this->getUser()->getRoles())){

            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder
                ->andWhere("$rootAlias.user = :user")
                ->setParameter('user', $this->getUser());
        }
        return $queryBuilder;
    }

    /**
     * @param Actions $actions
     * @return Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        $documentDetail = Action::new('document_detail')
            ->linkToCrudAction('documentDetail');
                return $actions->add(Crud::PAGE_INDEX, $documentDetail);
    }

    /**
     * @param string $pageName
     * @return iterable
     */
    public function configureFields(string $pageName): iterable
    {
        if(in_array('ROLE_ADMIN',  $this->getUser()->getRoles())) {
            yield EmailField::new('userMail')
                ->setLabel('User');
        }

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

    /**
     * @param Request $request
     * @param AdminContext $context
     * @return Response
     */
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
