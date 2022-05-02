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
    /**
     * @var int
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;


    /**
     * @var object
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    private object $user;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $image = null;

    /**
     * @var
     */
    #[ORM\Column(type: 'datetime')]
    private $lastModification;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return \DateTimeInterface|null
     */
    public function getLastModification(): ?\DateTimeInterface
    {
        return $this->lastModification;
    }

    /**
     * @param \DateTimeInterface $lastModification
     * @return $this
     */
    public function setLastModification(\DateTimeInterface $lastModification): self
    {
        $this->lastModification = $lastModification;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getUserMail(): string
    {
        return $this->user->getEmail();
    }

    /**
     * @param User|null $user
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param File|null $image
     * @return void
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param $image
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string|null
     */
    public function getImage()
    {
        return $this->image;
    }
}
