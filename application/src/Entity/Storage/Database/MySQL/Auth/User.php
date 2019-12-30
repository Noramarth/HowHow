<?php

declare(strict_types=1);

namespace App\Entity\Storage\Database\MySQL\Auth;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * Class User.
 *
 * @ORM\Entity()
 * @Table(
 *     name="users", indexes={
 *          @Index(
 *              name="username",
 *              columns={"user_name"}
 *          )
 *      },
 *     uniqueConstraints={
 *          @UniqueConstraint(
 *              name="unique_users",
 *              columns={
 *                  "user_name"
 *              }
 *          ),
 *     }
 * )
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="bigint", nullable=false)
     * @ORM\GeneratedValue()
     */
    public ?int $userId;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    public string $userName;

    /**
     * @ORM\OneToOne(targetEntity="Identity", fetch="EAGER", mappedBy="identityId")
     */
    public Identity $identity;

    /**
     * @ORM\OneToOne(targetEntity="PrivateUserInformation", fetch="EXTRA_LAZY", mappedBy="privateUserId")
     */
    public PrivateUserInformation $privateUserId;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public DateTime $dateAdded;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public DateTime $dateModified;

    public function __construct()
    {
        $this->dateAdded = new DateTime();
        $this->dateModified = $this->dateAdded;
    }

    /**
     * @return int
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): User
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): User
    {
        $this->userName = $userName;

        return $this;
    }

    public function getIdentity(): Identity
    {
        return $this->identity;
    }

    public function setIdentity(Identity $identity): User
    {
        $this->identity = $identity;

        return $this;
    }

    public function getPrivateUserId(): PrivateUserInformation
    {
        return $this->privateUserId;
    }

    public function setPrivateUserId(PrivateUserInformation $privateUserId): User
    {
        $this->privateUserId = $privateUserId;

        return $this;
    }
}
