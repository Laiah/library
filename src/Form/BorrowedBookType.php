<?php

namespace App\Form;

use App\Entity\BorrowedBook;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BorrowedBookType.
 *
 * @package App\Form
 */
class BorrowedBookType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'borrowingDate',
            DateType::class,
            [
                'label' => 'Date de début',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'input' => 'datetime'
            ]
        )
            ->add(
                'returnDate',
                DateType::class,
                [
                    'label' => 'Date de fin',
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'input' => 'datetime'
                ]
            )
            ->add(
                'user',
                EntityType::class,
                [
                    'class' => User::class,
                    'label' => 'Votre nom'
                ]
            )
            ->add(
                'reservation',
                ChoiceType::class,
                [
                    'choices' => [
                        'Maison' => BorrowedBook::MAISON,
                        'Bench' => BorrowedBook::BENCH
                    ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => BorrowedBook::class,
        ));
    }
}
