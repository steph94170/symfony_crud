<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[UniqueEntity('email', message: "Cet email appartient déja à l'un de vos contact")]
#[UniqueEntity('phone', message: "Ce numéro de téléphone  appartient déja à l'un de vos contact")]
#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[Assert\NotBlank(message: "le prénom est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage:" le prénom doit contenir au maximum {{ limit }} caractéres.",
    )]
    #[ORM\Column(length: 255)]
    private ?string $FirstName = null;
    

    #[Assert\NotBlank(message: "le prénom est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage:" le prénom doit contenir au maximum {{ limit }} caractéres.",
    )]
    #[ORM\Column(length: 255)]
    private ?string $LastName = null;

    #[Assert\NotBlank(message: "l'Email est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage:" l'Email doit contenir au maximum {{ limit }} caractéres.",
    )]
    #[Assert\Email(
        message: "l'email {{ value }} est invalide..",
    )]
    #[ORM\Column(length: 255, unique:true)]
    private ?string $email = null;

    #[Assert\NotBlank(message: "Le numéro de téléphone est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage:" le numéro de téléphone doit contenir au maximum {{ limit }} caractéres.",
    )]
    #[Assert\Regex("/^[0-9\s\-\(\)\+]{6,20}$/",message:"le numéro de téléphone est invalide.")]
    #[ORM\Column(length: 255, unique:true)]
    private ?string $phone = null;

    #[Assert\Length(
        max: 500,
        maxMessage:" le commentaire doit contenir au maximum {{ limit }} caractéres.",
    )]
    #[ORM\Column(type: Types::TEXT,nullable:true )]
    private ?string $comment = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(?string $FirstName): static
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(?string $LastName): static
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


}
