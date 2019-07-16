<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"email"}, message="It looks like your already have an account!")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank(groups={"Registration"})
     * @Assert\Length(min = 6, max = 4096, minMessage = "Min length password 6 symbol", maxMessage = "Max length password 4096 symbol")
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $surname;

    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    private $patronymic;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=8, max=20, minMessage="Min length phone 8 numbers", maxMessage="Max length phone 20 numbers")
     * @Assert\Regex(pattern="/^[0-9]*$/", message="Only numbers")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\Image(mimeTypes={"image/jpeg", "image/png"}, mimeTypesMessage="Picture format should be png or jpeg")
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $city;
    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\NotBlank(groups={"Lawyer"})
     */
    private $numberCertificate;

    /**
     * @ORM\Column(type="date", nullable=true, length=255)
     * @Assert\Date(groups={"Lawyer"})
     */
    private $dateCertificate;

    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\NotBlank(groups={"Lawyer"})
     */
    private $organization;

    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\NotBlank(groups={"Lawyer"})
     */
    private $position;

    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     * @Assert\NotBlank(groups={"Lawyer"})
     */
    private $kindOfActivity;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $enable = false;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $confirmationToken;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     * @return User
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoles(): ?array
    {
        $roles = $this->roles;

        if (!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }

        return $roles;
    }

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername(): ?string
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        $this->password = null;
    }

    public function getSalt()
    {

    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @return mixed
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     * @return User
     */
    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return User
     */
    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     * @return User
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateCertificate()
    {
        return $this->dateCertificate;
    }

    /**
     * @param mixed $dateCertificate
     * @return User
     */
    public function setDateCertificate(string $dateCertificate): self
    {
        $this->dateCertificate = $dateCertificate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKindOfActivity(): ?string
    {
        return $this->kindOfActivity;
    }

    /**
     * @param mixed $kindOfActivity
     * @return User
     */
    public function setKindOfActivity(string $kindOfActivity): self
    {
        $this->kindOfActivity = $kindOfActivity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumberCertificate(): ?string
    {
        return $this->numberCertificate;
    }

    /**
     * @param mixed $numberCertificate
     * @return User
     */
    public function setNumberCertificate(string $numberCertificate): self
    {
        $this->numberCertificate = $numberCertificate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    /**
     * @param mixed $organization
     * @return User
     */
    public function setOrganization(string $organization): self
    {
        $this->organization = $organization;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     * @return User
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    /**
     * @param mixed $patronymic
     * @return User
     */
    public function setPatronymic(string $patronymic): self
    {
        $this->patronymic = $patronymic;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return User
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosition(): ?string
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     * @return User
     */
    public function setPosition(string $position): self
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return User
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEnable(): bool
    {
        return $this->enable;
    }

    /**
     * @param mixed $enable
     * @return User
     */
    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    /**
     * @param mixed $confirmationToken
     * @return User
     */
    public function setConfirmationToken(string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     * @return User
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

}