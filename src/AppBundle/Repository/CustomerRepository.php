<?php
/**
 * Created by PhpStorm.
 * User: Juste
 * Date: 2018-02-14
 * Time: 11:39
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Customer;
use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository
{
    /**
     * @param Customer $customer
     * @return Customer
     */
    public function findOneByCustomer(Customer $customer) {
        return $this->createQueryBuilder('customer')
            ->andWhere('customer.name = :name')
            ->setParameter('name', $customer->getName())
            ->andWhere('customer.surname= :surname')
            ->setParameter('surname', $customer->getSurname())
            ->andWhere('customer.email = :email')
            ->setParameter('email', $customer->getEmail())
            ->andWhere('customer.country = :country')
            ->setParameter('country', $customer->getCountry())
            ->andWhere('customer.city = :city')
            ->setParameter('city', $customer->getCity())
            ->andWhere('customer.address = :address')
            ->setParameter('address', $customer->getAddress())
            ->andWhere('customer.phoneNumber = :phoneNumber')
            ->setParameter('phoneNumber', $customer->getPhoneNumber())
            ->getQuery()
            ->execute();
    }
}