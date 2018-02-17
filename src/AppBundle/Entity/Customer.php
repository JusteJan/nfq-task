<?php
/**
 * Created by PhpStorm.
 * User: Juste
 * Date: 2018-02-12
 * Time: 19:18
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerRepository")
 * @ORM\Table(name="customer")
 *
 */

class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Country")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $surname;

    /**
     * @Assert\NotBlank()
     * @Assert\Email(message="Įvestas netaisyklingas elektroninio pašto adresas.")
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[\+]?(?:[\d]+)$/",
     *               message="Telefono numerį gali sudaryti tik skaičiai ir simbolis '+'.")
     * @ORM\Column(type="string")
     */
    private $phoneNumber;


    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }


}