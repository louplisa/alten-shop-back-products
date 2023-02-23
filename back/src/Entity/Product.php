<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product {

  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  #[Groups(["getProducts"])]
  private int $id;

  #[ORM\Column(length: 255)]
  #[Groups(["getProducts"])]
  private string $code;

  #[ORM\Column(length: 255)]
  #[Groups(["getProducts"])]
  private string $name;

  #[ORM\Column(type: Types::TEXT)]
  #[Groups(["getProducts"])]
  private string $description;

  #[ORM\Column]
  #[Groups(["getProducts"])]
  private int $price;

  #[ORM\Column]
  #[Groups(["getProducts"])]
  private int $quantity;

  #[ORM\Column(length: 255)]
  #[Groups(["getProducts"])]
  private string $inventoryStatus;

  #[ORM\Column(length: 255)]
  #[Groups(["getProducts"])]
  private string $category;

  #[ORM\Column(length: 255, nullable: TRUE)]
  #[Groups(["getProducts"])]
  private ?string $image = NULL;

  #[ORM\Column(nullable: TRUE)]
  #[Groups(["getProducts"])]
  private ?int $rating = NULL;

  public function getId(): int {
    return $this->id;
  }

  public function getCode(): string {
    return $this->code;
  }

  public function setCode(string $code): self {
    $this->code = $code;

    return $this;
  }

  public function getName(): string {
    return $this->name;
  }

  public function setName(string $name): self {
    $this->name = $name;

    return $this;
  }

  public function getDescription(): string {
    return $this->description;
  }

  public function setDescription(string $description): self {
    $this->description = $description;

    return $this;
  }

  public function getPrice(): int {
    return $this->price;
  }

  public function setPrice(int $price): self {
    $this->price = $price;

    return $this;
  }

  public function getQuantity(): int {
    return $this->quantity;
  }

  public function setQuantity(int $quantity): self {
    $this->quantity = $quantity;

    return $this;
  }

  public function getInventoryStatus(): string {
    return $this->inventoryStatus;
  }

  public function setInventoryStatus(string $inventoryStatus): self {
    $this->inventoryStatus = $inventoryStatus;

    return $this;
  }

  public function getCategory(): string {
    return $this->category;
  }

  public function setCategory(string $category): self {
    $this->category = $category;

    return $this;
  }

  public function getImage(): ?string {
    return $this->image;
  }

  public function setImage(?string $image): self {
    $this->image = $image;

    return $this;
  }

  public function getRating(): ?int {
    return $this->rating;
  }

  public function setRating(?int $rating): self {
    $this->rating = $rating;

    return $this;
  }

}
