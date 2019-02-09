<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\DependencyInjection\Tests\Compiler\C;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Adress", mappedBy="city")
     */
    private $adress;

    public function __construct()
    {
        $this->adress = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * get adress
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Add adress
     *
     * @param Adress $adress
     *
     * @return City
     */
    public function addAdress(Adress $adress)
    {
        $this->adress[] = $adress;

        return $this;
    }
}
