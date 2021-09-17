<?php

namespace App\Form;

use App\Entity\Todos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TodosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('task')
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Incomplete' => "Incomplete",
                    'In Progress' => "In Progress",
                    'Complete' => "Complete",
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Todos::class,
        ]);
    }
}
