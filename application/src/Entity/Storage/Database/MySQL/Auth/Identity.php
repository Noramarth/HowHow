<?php

declare(strict_types=1);

namespace App\Entity\Storage\Database\MySQL\Auth;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Identity.
 *
 * @ORM\Entity()
 */
class Identity
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     */
    public string $identityId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public ?string $token;

    public function getIdentityId(): string
    {
        return $this->identityId;
    }

    public function setIdentityId(string $identityId): Identity
    {
        $this->identityId = $identityId;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): Identity
    {
        $this->password = $password;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): Identity
    {
        $this->token = $token;

        return $this;
    }
}
