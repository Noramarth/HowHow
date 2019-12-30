<?php

namespace App\Entity\Storage\Database\MySQL\Auth;

use App\Entity\Storage\Database\MySQL\Biography;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PrivateUserInformation.
 *
 * @ORM\Entity()
 */
class PrivateUserInformation
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     */
    public string $privateUserId;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Email()
     */
    public ?string $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $firstName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $middleName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $lastName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $penName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $avatar;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Storage\Database\MySQL\Biography", mappedBy="biographyId")
     */
    public ?Biography $bio;


    public function getPrivateUserId(): ?int
    {
        return $this->privateUserId;
    }

    public function setPrivateUserId(?int $privateUserId): PrivateUserInformation
    {
        $this->privateUserId = $privateUserId;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): PrivateUserInformation
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): PrivateUserInformation
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(?string $middleName): PrivateUserInformation
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): PrivateUserInformation
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPenName(): ?string
    {
        return $this->penName;
    }

    public function setPenName(?string $penName): PrivateUserInformation
    {
        $this->penName = $penName;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): PrivateUserInformation
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getBio(): ?Biography
    {
        return $this->bio;
    }

    public function setBio(?Biography $bio): PrivateUserInformation
    {
        $this->bio = $bio;

        return $this;
    }
}
