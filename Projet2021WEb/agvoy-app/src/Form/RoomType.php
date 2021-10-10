<?php

namespace App\Form;

use App\Entity\Room;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
        $builder
            ->add('address')
            ->add('capacity')
            ->add('description')
            ->add('price')
            ->add('owner')
            ->add('summary')
            ->add('superficy')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
            'task_is_new' => false
        ]);
        $resolver->setAllowedTypes('task_is_new', 'bool');
    }
}
