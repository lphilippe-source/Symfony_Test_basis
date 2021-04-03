<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $mayor;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class)
     */
    private $relation;
    public function  __construct(){

        $this->name='';
        $this->mayor='';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMayor(): ?string
    {
        return $this->mayor;
    }

    public function setMayor(string $mayor): self
    {
        $this->mayor = $mayor;

        return $this;
    }

    public function getRelation(): ?Country
    {
        return $this->relation;
    }

    public function setRelation(?Country $relation): self
    {
        $this->relation = $relation;

        return $this;
    }
}
