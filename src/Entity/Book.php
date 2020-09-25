<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @Vich\Uploadable
 */
class Book
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ref;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @Vich\UploadableField(mapping="photo_image", fileNameProperty="photo")
     * @var File
     */
    private $photoFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $buyPrice;

    /**
     * @ORM\Column(type="float")
     */
    private $soldPrice;

    /**
     * @ORM\Column(type="float")
     */
    private $rentPrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\Column(type="integer")
     */
    private $sold;

    /**
     * @ORM\Column(type="integer")
     */
    private $rent;

    /**
     * @ORM\Column(type="datetime")
     *@var \DateTime
     */
        private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Flow::class, mappedBy="book")
     */
    private $flows;

    /**
     * @ORM\OneToMany(targetEntity=CustomerFlow::class, mappedBy="book")
     */
    private $customerFlows;

    public function __construct()
    {
        $this->flows = new ArrayCollection();
        $this->customerFlows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function setPhotoFile(File $photo = null)
    {
        $this->photoFile = $photo;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($photo) {
            // if 'updatedAt' is not defined in your entity, use another property
          $this->updatedAt = new \DateTime('now');
          }
        }
        public function getPhotoFile(): ?File
    {
        return $this->photoFile;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBuyPrice(): ?float
    {
        return $this->buyPrice;
    }

    public function setBuyPrice(float $buyPrice): self
    {
        $this->buyPrice = $buyPrice;

        return $this;
    }

    public function getSoldPrice(): ?float
    {
        return $this->soldPrice;
    }

    public function setSoldPrice(float $soldPrice): self
    {
        $this->soldPrice = $soldPrice;

        return $this;
    }

    public function getRentPrice(): ?float
    {
        return $this->rentPrice;
    }

    public function setRentPrice(float $rentPrice): self
    {
        $this->rentPrice = $rentPrice;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getSold(): ?int
    {
        return $this->sold;
    }

    public function setSold(int $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getRent(): ?int
    {
        return $this->rent;
    }

    public function setRent(int $rent): self
    {
        $this->rent = $rent;

        return $this;
    }

    /**
     * @return Collection|Flow[]
     */
    public function getFlows(): Collection
    {
        return $this->flows;
    }

    public function addFlow(Flow $flow): self
    {
        if (!$this->flows->contains($flow)) {
            $this->flows[] = $flow;
            $flow->setBook($this);
        }

        return $this;
    }

    public function removeFlow(Flow $flow): self
    {
        if ($this->flows->contains($flow)) {
            $this->flows->removeElement($flow);
            // set the owning side to null (unless already changed)
            if ($flow->getBook() === $this) {
                $flow->setBook(null);
            }
        }

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
            $customerFlow->setBook($this);
        }

        return $this;
    }

    public function removeCustomerFlow(CustomerFlow $customerFlow): self
    {
        if ($this->customerFlows->contains($customerFlow)) {
            $this->customerFlows->removeElement($customerFlow);
            // set the owning side to null (unless already changed)
            if ($customerFlow->getBook() === $this) {
                $customerFlow->setBook(null);
            }
        }

        return $this;
    }
}
