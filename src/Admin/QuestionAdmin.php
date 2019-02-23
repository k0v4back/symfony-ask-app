<?php

namespace App\Admin;

use App\Entity\Questions;
use App\Helpers\GetAllUsersHelper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class QuestionAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $users = new GetAllUsersHelper();
        $formMapper
            ->add('who_asked', ChoiceType::class, [
                'choices'  => $users->getAll()
            ])
            ->add('to_asked', ChoiceType::class, [
                'choices'  => $users->getAll()
            ])
            ->add('text', TextareaType::class)
            ->add('time', TimeType::class, [
                'input'  => 'timestamp',
                'widget' => 'choice',
            ])
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Not answered' => Questions::NOT_ANSWERED,
                    'Answered' => Questions::ANSWERED,
                ],
            ])
            ->add('anon', ChoiceType::class, [
                'choices'  => [
                    'Anon' => true,
                    'Public' => false,
                ],
            ])
            ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('who_asked');
        $datagridMapper->add('to_asked');
        $datagridMapper->add('text');
        $datagridMapper->add('time');
        $datagridMapper->add('status');
        $datagridMapper->add('anon');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('who_asked');
        $listMapper->addIdentifier('to_asked');
        $listMapper->addIdentifier('text');
        $listMapper->addIdentifier('time');
        $listMapper->addIdentifier('status');
        $listMapper->addIdentifier('anon');
    }
}