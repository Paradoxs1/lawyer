<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sonata\AdminBundle\Show\ShowMapper;

class PartnerAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->isCurrentRoute('edit')) {
            $partner = $this->getSubject();
            $fileFieldOptions = ['required' => false];

            if ($partner && ($webPath = $partner->getFileName())) {
                $container = $this->getConfigurationPool()->getContainer();
                $fullPath = $container->get('request_stack')->getCurrentRequest()->getBasePath().'/'.$webPath;
                $fileFieldOptions['help'] = '<img src="/img/partner_images'.$fullPath.'" class="admin-preview" />';
            }
        }

        $formMapper
            ->add('title', null, ['label' => 'Название компании'])
            ->add('site', null, ['label' => 'Сайт компании']);
            if ($this->isCurrentRoute('create')) {
                $formMapper->add('file', FileType::class, [
                    'data_class' => null
                ]);
            }
            if ($this->isCurrentRoute('edit')) {
                $formMapper->add('file', FileType::class, $fileFieldOptions);
            }
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, ['label' => 'Название компании'])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, ['label' => 'Название компании'])
            ->add('site', null, ['label' => 'Сайт компании'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => []
                ]
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title', null, ['label' => 'Название компании'])
            ->add('site', null, ['label' => 'Сайт компании'])
            ->add('filename', null, [
                'required' => false,
                'template' => 'views/image.html.twig'
            ])
        ;
    }
}