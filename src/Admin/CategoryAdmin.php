<?php

namespace App\Admin;

use App\Entity\Category;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslatedEntityType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Sonata\AdminBundle\Show\ShowMapper;

class CategoryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('translations', TranslationsType::class,[
                'locales' => ['en', 'ru', 'ua'],
                'default_locale' => ['ru'],
                'required_locales' => ['ua', 'en', 'ua'],
                'label' => 'Категория',
                'fields' => [
                    'title' => [
                        'label' => 'Название категории на русском',
                        'locale_options' => [
                            'en' => ['label' => 'Category title on english'],
                            'ua' => ['label' => 'Назва категорії українською'],
                        ]
                    ]
                ],
                'excluded_fields' => ['details']
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('translations', null, ['label' => 'Название категории'], TranslatedEntityType::class, array(
                'class' => Category::class,
                'translation_property' => 'title'
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, ['label' => 'Название категории'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => []
                ]
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title', TranslatedEntityType::class, [
                'class' => Category::class,
                'translation_property' => 'title',
                'multiple' => true,
                'label' => 'Название категории'
            ])
        ;
    }
}