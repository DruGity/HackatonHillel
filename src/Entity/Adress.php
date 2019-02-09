<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdressRepository")
 */
class Adress
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="adress", cascade={"persist"})
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id",nullable=false)
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="adress", cascade={"persist"})
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id",nullable=false)
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Street", inversedBy="adress", cascade={"persist"})
     * @ORM\JoinColumn(name="street_id", referencedColumnName="id",nullable=false)
     */
    private $street;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="adress")
     */
    private $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->user;
    }

    /**
     * Add users
     *
     * @param User $users
     *
     * @return Adress
     */
    public function addUsers(User $users)
    {
        $this->user[] = $users;

        return $this;
    }
}
