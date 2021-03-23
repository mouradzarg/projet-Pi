<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */

class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("users")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\NotBlank(message="le nom est obligatoir")
     * @Groups("users")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\NotBlank(message="le prenom est obligatoir")
     * @Groups("users")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Email(message="le email non valide")
     * @Groups("users")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups("users")
     */
    private $numTel;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("users")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=8)
     * @Groups("users")
     */
    private $cin;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("users")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups("users")
     */
    private $compteType;

    /**
     * @ORM\Column(type="date")
     * @Groups("users")
     */
    private $dateNaiss;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): self
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCompteType(): ?string
    {
        return $this->compteType;
    }

    public function setCompteType(string $compteType): self
    {
        $this->compteType = $compteType;

        return $this;
    }

    public function getDateNaiss(): ?\DateTimeInterface
    {
        return $this->dateNaiss;
    }

    public function setDateNaiss(\DateTimeInterface $dateNaiss): self
    {
        $this->dateNaiss = $dateNaiss;

        return $this;
    }}



