<?php

namespace App\Admin;

use App\Entity\Category;
use App\Entity\Product;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslatedEntityType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $locale  = 'ru';

        if ($this->isCurrentRoute('edit')) {
            $product = $this->getSubject();
            $fileFieldOptions = ['required' => false];

            if ($product && ($webPath = $product->getFileName())) {
                $container = $this->getConfigurationPool()->getContainer();
                $fullPath = $container->get('request_stack')->getCurrentRequest()->getBasePath().'/'.$webPath;
                $fileFieldOptions['help'] = '<img src="/img/product_images'.$fullPath.'" class="admin-preview" />';
            }
        }

        $formMapper
            ->add('translations', TranslationsType::class,[
                'locales' => ['en', 'ru', 'ua'],
                'default_locale' => ['ru'],
                'required_locales' => ['ua', 'en', 'ua'],
                'label' => 'Новость',
                'fields' => [
                    'title' => [
                        'label' => 'Название продукта на русском',
                        'locale_options' => [
                            'en' => ['label' => 'Product title on english'],
                            'ua' => ['label' => 'Назва продукту українською'],
                        ]
                    ],
                    'description' => [
                        'label' => 'Описание продукта на русском',
                        'locale_options' => [
                            'en' => ['label' => 'Product description on english'],
                            'ua' => ['label' => 'Опис продукту українською'],
                        ]
                    ],
                    'color' => [
                        'label' => 'Цвет продукта на русском',
                        'locale_options' => [
                            'en' => ['label' => 'Product color on english'],
                            'ua' => ['label' => 'Колір продукту українською'],
                        ]
                    ]
                ],
                'excluded_fields' => ['details']
            ])
            ->add('slug', null, ['label' => 'Slug'])
            ->add('price', null, ['label' => 'Цена'])
            ->add('currency', null, ['label' => 'Валюта'])
            ->add('category', EntityType::class,[
                'class' => Category::class,
                'label' => 'Категория',
                'choice_label'=> "translations[{$locale}].title",
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
                'class' => Product::class,
                'translation_property' => 'title'
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, ['label' => 'Название'])
            ->add('description', null, ['label' => 'Описание'])
            ->add('price', null, ['label' => 'Цена'])
            ->add('currency', null, ['label' => 'Валюта'])
            ->add('color', null, ['label' => 'Цвет'])
            ->add('slug', null, ['label' => 'Slug'])
            ->add('created_at', null, ['label' => 'Дата создания/редактирования'])
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
                'class' => Product::class,
                'translation_property' => 'title',
                'multiple' => true,
                'label' => 'Название'
            ])
            ->add('description', TranslatedEntityType::class, [
                'class' => Product::class,
                'translation_property' => 'description',
                'multiple' => true,
                'label' => 'Описание'
            ])
            ->add('price', null, ['label' => 'Цена'])
            ->add('currency', null, ['label' => 'Валюта'])
            ->add('color', TranslatedEntityType::class, [
                'class' => Product::class,
                'translation_property' => 'content',
                'multiple' => true,
                'label' => 'Цвет'
            ])
            ->add('created_at', null, ['label' => 'Дата создания/редактирования'])
            ->add('filename', null, [
                'required' => false,
                'template' => 'views/image.html.twig'
            ])
        ;
    }
}