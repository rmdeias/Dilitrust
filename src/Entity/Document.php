<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    /*
    #[ORM\Column(type: 'string', length: 255)]
    private string $file;*/
/*
    #[ORM\Column(type: 'datetime')]
    private $updatedAt;*/

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    private object $user;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: 'datetime')]
    private $lastModification;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getLastModification(): ?\DateTimeInterface
    {
        return $this->lastModification;
    }

    public function setLastModification(\DateTimeInterface $lastModification): self
    {
        $this->lastModification = $lastModification;

        return $this;
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

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        ///if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            //$this->updatedAt = new \DateTime('now');
        //}
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }
}
