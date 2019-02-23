<?php

namespace App\Admin;

use App\Helpers\GetAllUsersHelper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnswerAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $users = new GetAllUsersHelper();
        $formMapper
            ->add('user_id', ChoiceType::class, [
                'choices'  => $users->getAll()
            ])
            ->add('to_user_id', ChoiceType::class, [
                'choices'  => $users->getAll()
            ])
            ->add('text', TextareaType::class)
            ->add('question_id', ChoiceType::class, [
                'choices'  => [
                    'First' => 1
                ]
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('user_id')
            ->add('to_user_id')
            ->add('text')
            ->add('question_id')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('user_id');
        $listMapper->addIdentifier('to_user_id');
        $listMapper->addIdentifier('text');
        $listMapper->addIdentifier('question_id');
    }
}