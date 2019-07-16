<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Post
{
    use ORMBehaviors\Translatable\Translatable;

    const SERVER_PATH_TO_IMAGE_FOLDER = 'img/news_images';
    const LIMIT_FOR_MAIN_PAGE = 4;
    const LIMIT_FOR_SINGLE_PAGE = 5;
    const LIMIT_FOR_NEWS_PAGE = 8;

    /**
     * This function makes it possible to call translated properties without having to know if the enitity is translated.
     * @param $method
     * @param $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (!method_exists(self::getTranslationEntityClass(), $method)) {
            $method = 'get'. ucfirst($method);
        }

        return $this->proxyCurrentLocaleTranslation($method, $args);
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    private $file;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $slug;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile ()
    {
        return $this->file ;
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        $fileName = md5(uniqid()).''.$this->getFile()->getClientOriginalName();
        $this->getFile()->move(self::SERVER_PATH_TO_IMAGE_FOLDER, $fileName);
        $this->filename = $fileName;
        $this->setFile(null);
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate()
     *
     * Lifecycle callback to upload the file to the server
     */
    public function lifecycleFileUpload()
    {
        $this->upload();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate()
     */
    public function setCreatedAtValue()
    {
        $this->created_at = new \DateTime();
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
