<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25.09.18
 * Time: 13:06
 */

namespace App\Admin;

use App\Entity\Post;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslatedEntityType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sonata\AdminBundle\Show\ShowMapper;

class PostAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->isCurrentRoute('edit')) {
            $post = $this->getSubject();
            $fileFieldOptions = ['required' => false];

            if ($post && ($webPath = $post->getFileName())) {
                $container = $this->getConfigurationPool()->getContainer();
                $fullPath = $container->get('request_stack')->getCurrentRequest()->getBasePath().'/'.$webPath;
                $fileFieldOptions['help'] = '<img src="/img/news_images'.$fullPath.'" class="admin-preview" />';
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
                        'label' => 'Заголовок новости на русском',
                        'locale_options' => [
                            'en' => ['label' => 'News title on english'],
                            'ua' => ['label' => 'Заголовок новини українською'],
                        ]
                    ],
                    'description' => [
                        'label' => 'Описание новости на русском',
                        'locale_options' => [
                            'en' => ['label' => 'News description on english'],
                            'ua' => ['label' => 'Опис новини українською'],
                        ]
                    ],
                    'content' => [
                        'label' => 'Содержание новости на русском',
                        'locale_options' => [
                            'en' => ['label' => 'News content on english'],
                            'ua' => ['label' => 'Зміст новини українською'],
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
            ->add('translations', null, ['label' => 'Заголовок'], TranslatedEntityType::class, array(
                'class' => Post::class,
                'translation_property' => 'title'
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, ['label' => 'Заголовок'])
            ->add('description', null, ['label' => 'Описание'])
            ->add('content', null, ['label' => 'Содержание'])
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
                'class' => Post::class,
                'translation_property' => 'title',
                'multiple' => true,
                'label' => 'Заголовок'
            ])
            ->add('description', TranslatedEntityType::class, [
                'class' => Post::class,
                'translation_property' => 'description',
                'multiple' => true,
                'label' => 'Описание'
            ])
            ->add('content', TranslatedEntityType::class, [
                'class' => Post::class,
                'translation_property' => 'content',
                'multiple' => true,
                'label' => 'Содержание'
            ])
            ->add('created_at', null, ['label' => 'Дата создания'])
            ->add('filename', null, [
                'required' => false,
                'template' => 'views/image.html.twig'
            ])
        ;
    }
}