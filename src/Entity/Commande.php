<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $User = null;

    #[ORM\Column(nullable: true)]
    private ?int $Quantite = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datecommande = null;

    /**
     * @var Collection<int, Produits>
     */
    #[ORM\ManyToMany(targetEntity: Produits::class)]
    private Collection $produit;

    #[ORM\Column]
    private ?float $prixTotal = null;

    #[ORM\Column(length: 255)]
    private ?string $tx = null;

    #[ORM\Column]
    private ?bool $isPayer = null;

    public function __construct()
    {
        $this->produit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->Quantite;
    }

    public function setQuantite(int $Quantite): static
    {
        $this->Quantite = $Quantite;

        return $this;
    }

    public function getDatecommande(): ?\DateTimeInterface
    {
        return $this->datecommande;
    }

    public function setDatecommande(\DateTimeInterface $datecommande): static
    {
        $this->datecommande = $datecommande;

        return $this;
    }

    /**
     * @return Collection<int, Produits>
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(Produits $produit): static
    {
        if (!$this->produit->contains($produit)) {
            $this->produit->add($produit);
        }

        return $this;
    }

    public function removeProduit(Produits $produit): static
    {
        $this->produit->removeElement($produit);

        return $this;
    }

    public function getPrixTotal(): ?float
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(float $prixTotal): static
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getTx(): ?string
    {
        return $this->tx;
    }

    public function setTx(string $tx): static
    {
        $this->tx = $tx;

        return $this;
    }

    public function isPayer(): ?bool
    {
        return $this->isPayer;
    }

    public function setPayer(bool $isPayer): static
    {
        $this->isPayer = $isPayer;

        return $this;
    }
}
