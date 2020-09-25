<?php

namespace App\Entity;

use App\Repository\CustomerFlowRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerFlowRepository::class)
 */
class CustomerFlow
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="customerFlows")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="customerFlows")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity=Flow::class, inversedBy="customerFlows")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Flow;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getFlow(): ?Flow
    {
        return $this->Flow;
    }

    public function setFlow(?Flow $Flow): self
    {
        $this->Flow = $Flow;

        return $this;
    }
}
