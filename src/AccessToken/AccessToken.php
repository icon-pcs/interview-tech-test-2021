<?php declare(strict_types=1);

namespace IconLanguageServices\ApiClient\AccessToken;

use DateTimeImmutable;

class AccessToken
{
    private DateTimeImmutable $expiresAt;
    private string $token;

    public function __construct(DateTimeImmutable $expiresAt, string $token)
    {
        $this->expiresAt = $expiresAt;
        $this->token = $token;
    }

    public function hasExpired(): bool
    {
        return $this->expiresAt->format("U") < time();
    }

    public function expiresInNext(int $seconds): bool
    {
        return $this->expiresAt->format("U") - $seconds < time();
    }

    public function expiresAt(): DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function token(): string
    {
        return $this->token;
    }
}
