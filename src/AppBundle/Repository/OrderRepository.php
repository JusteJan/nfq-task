<?php
/**
 * Created by PhpStorm.
 * User: Juste
 * Date: 2018-02-15
 * Time: 09:17
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository
{
    //Randama visa informacija lentelei
    public function findAllTableInformation()
    {
        return $this->createQueryBuilder('orders')
            ->leftJoin('orders.customer', 'customer')
            ->select('orders.id as id, customer.name as name,
            customer.surname as surname, orders.date as date,
            orders.quantity as quantity, orders.totalPrice as totalPrice')
            ->getQuery()
            ->execute();

    }

    //Randama užsakymo informacija vienam užsakovui pagal jo id
    public function findOneWithCustomerById($orderId)
    {
        return $this->createQueryBuilder('orders')
            ->leftJoin('orders.customer', 'customer')
            ->leftJoin('customer.country', 'country')
            ->andWhere('orders.id = :id')
            ->setParameter('id', $orderId)
            ->select('orders.id as id, orders.date as date,
            orders.quantity as quantity, orders.totalPrice as totalPrice,
            customer.name as name, customer.surname as surname,
            customer.email as email, customer.address as address,
            customer.city as city, customer.phoneNumber as phoneNumber,
            country.name as countryName')
            ->getQuery()
            ->execute();
    }
}