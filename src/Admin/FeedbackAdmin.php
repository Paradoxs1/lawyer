<?php

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

class FeedbackAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('message', null, ['label' => 'Сообщение'])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('userSurname', null, ['label' => 'Фамилия'])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('userSurname', null, ['label' => 'Фамилия'])
            ->add('subject', null, ['label' => 'Тема'])
            ->add('message', null, ['label' => 'Сообщение'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'delete' => []
                ]
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('userName', null, ['label' => 'Имя юзера'])
            ->add('userSurname', null, ['label' => 'Фамилия юзера'])
            ->add('userPhone', null, ['label' => 'Телефон юзера'])
            ->add('subject', null, ['label' => 'Тема'])
            ->add('message', null, ['label' => 'Сообщение'])
        ;
    }
}