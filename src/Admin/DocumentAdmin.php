<?php

namespace App\Admin;

use App\Entity\Document;
use App\Entity\Post;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslatedEntityType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sonata\AdminBundle\Show\ShowMapper;

class DocumentAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->isCurrentRoute('edit')) {
            $document = $this->getSubject();
            $fileFieldOptions = ['required' => false];

            if ($document && ($webPath = $document->getFileName())) {
                $container = $this->getConfigurationPool()->getContainer();
                $fullPath = $container->get('request_stack')->getCurrentRequest()->getBasePath().'/'.$webPath;
                $fileFieldOptions['help'] = '<img src="/img/document_images'.$fullPath.'" class="admin-preview" />';
            }
        }

        $formMapper
            ->add('translations', TranslationsType::class,[
                'locales' => ['en', 'ru', 'ua'],
                'default_locale' => ['ru'],
                'required_locales' => ['ua', 'en', 'ua'],
                'label' => 'Документ',
                'fields' => [
                    'title' => [
                        'label' => 'Название документа',
                        'locale_options' => [
                            'en' => ['label' => 'Document title on english'],
                            'ua' => ['label' => 'Назва документа українською'],
                        ]
                    ]
                ],
                'excluded_fields' => ['details']
            ])
            ->add('slug', null, ['label' => 'Slug']);
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
            ->add('translations', null, ['label' => 'Название'], TranslatedEntityType::class, array(
                'class' => Post::class,
                'translation_property' => 'title'
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, ['label' => 'Название'])
            ->add('slug', null, ['label' => 'Slug'])
            ->add('created_at', null, ['label' => 'Дата создания'])
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
            ->add('title', TranslatedEntityType::class, [
                'class' => Document::class,
                'translation_property' => 'title',
                'multiple' => true,
                'label' => 'Название'
            ])
            ->add('created_at', null, ['label' => 'Дата создания'])
            ->add('filename', null, [
                'required' => false,
                'template' => 'views/image.html.twig'
            ])
        ;
    }
}