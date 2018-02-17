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
    //Ieško užsakovo
    public function findOneByOneCustomer(Customer $customer) {
        return $this->findOneBy([
            'name' => $customer->getName(),
            'surname' => $customer->getSurname(),
            'email' => $customer->getEmail(),
            'country' => $customer->getCountry(),
            'city' => $customer->getCity(),
            'address' => $customer->getAddress(),
            'phoneNumber' => $customer->getPhoneNumber(),
        ]);
    }
}