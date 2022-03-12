<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
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
    private $name_produit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marque_produit;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity_produit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameProduit(): ?string
    {
        return $this->name_produit;
    }

    public function setNameProduit(string $name_produit): self
    {
        $this->name_produit = $name_produit;

        return $this;
    }

    public function getMarqueProduit(): ?string
    {
        return $this->marque_produit;
    }

    public function setMarqueProduit(string $marque_produit): self
    {
        $this->marque_produit = $marque_produit;

        return $this;
    }

    public function getQuantityProduit(): ?int
    {
        return $this->quantity_produit;
    }

    public function setQuantityProduit(int $quantity_produit): self
    {
        $this->quantity_produit = $quantity_produit;

        return $this;
    }
}
