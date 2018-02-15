<?php
/**
 * Created by PhpStorm.
 * User: Juste
 * Date: 2018-02-13
 * Time: 20:18
 */

namespace AppBundle\Form;


use AppBundle\Entity\Country;
use AppBundle\Entity\Customer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('surname')
            ->add('email')
            ->add('country', EntityType::class, [
                'class' => Country::class])
            ->add('city')
            ->add('address')
            ->add('phoneNumber');

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>Customer::class
        ]);
    }

}