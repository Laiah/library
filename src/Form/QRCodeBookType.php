<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QRCodeBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('selected_books', EntityType::class, [
                'required'      => false,
                'class'         => Book::class,
                'multiple'      => true,
                'expanded'      => true,
                'choice_label'  => function($book) {
                    return $this->getChoiceLabel($book);
                }
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Generate and print QR Codes',
                'attr'  => [
                  'class' => 'primary btn-primary'
                ]
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => null,
            'csrf_protection' => false,
        ));
    }

    /**
     * @param BookEntity $book
     *
     * @return string
     */
    protected function getChoiceLabel($book): string
    {
        return sprintf("%s | #%s (%s)",
          $book->getTitle(),
          $book->getOwner()->getUsername(),
          $book->getLocation()
        );
    }
}