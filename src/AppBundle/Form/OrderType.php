<?php
/**
 * Created by PhpStorm.
 * User: Juste
 * Date: 2018-02-13
 * Time: 20:19
 */

namespace AppBundle\Form;


use AppBundle\Entity\Orders;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer', CustomerType::class)
            ->add('date', DateType::class, [
                'disabled'=>true
            ])
            ->add('quantity')
            ->add('totalPrice', MoneyType::class, [
                'attr' => ['readonly' => true]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>Orders::class
        ]);
    }
}