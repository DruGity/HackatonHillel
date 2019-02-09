<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 */
class Country
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
     * @ORM\OneToMany(targetEntity="App\Entity\Adress", mappedBy="country")
     */
    private $adress;

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
     * @return Country
     */
    public function addAdress(Adress $adress)
    {
        $this->adress[] = $adress;

        return $this;
    }

}
