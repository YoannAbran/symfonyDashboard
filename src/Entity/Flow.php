<?php

namespace App\Entity;

use App\Repository\FlowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FlowRepository::class)
 */
class Flow
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="flows")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $buyDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $rentDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $returnDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $returnOk;

    /**
     * @ORM\OneToMany(targetEntity=CustomerFlow::class, mappedBy="Flow")
     */
    private $customerFlows;

    public function __construct()
    {
        $this->customerFlows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBuyDate(): ?\DateTimeInterface
    {
        return $this->buyDate;
    }

    public function setBuyDate(\DateTimeInterface $buyDate): self
    {
        $this->buyDate = $buyDate;

        return $this;
    }

    public function getRentDate(): ?\DateTimeInterface
    {
        return $this->rentDate;
    }

    public function setRentDate(?\DateTimeInterface $rentDate): self
    {
        $this->rentDate = $rentDate;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(?\DateTimeInterface $returnDate): self
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getReturnOk(): ?bool
    {
        return $this->returnOk;
    }

    public function setReturnOk(?bool $returnOk): self
    {
        $this->returnOk = $returnOk;

        return $this;
    }

    /**
     * @return Collection|CustomerFlow[]
     */
    public function getCustomerFlows(): Collection
    {
        return $this->customerFlows;
    }

    public function addCustomerFlow(CustomerFlow $customerFlow): self
    {
        if (!$this->customerFlows->contains($customerFlow)) {
            $this->customerFlows[] = $customerFlow;
            $customerFlow->setFlow($this);
        }

        return $this;
    }

    public function removeCustomerFlow(CustomerFlow $customerFlow): self
    {
        if ($this->customerFlows->contains($customerFlow)) {
            $this->customerFlows->removeElement($customerFlow);
            // set the owning side to null (unless already changed)
            if ($customerFlow->getFlow() === $this) {
                $customerFlow->setFlow(null);
            }
        }

        return $this;
    }
}
