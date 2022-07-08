<?php

declare(strict_types=1);

namespace AlleKurier\ApiV2\Command\User\Login;

use AlleKurier\ApiV2\Command\AbstractRequest;
use AlleKurier\ApiV2\Command\RequestInterface;
use AlleKurier\ApiV2\Command\ResponseInterface;

class LoginRequest extends AbstractRequest implements RequestInterface
{
    private string $email;

    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * {@inheritDoc}
     */
    public function isCredentialsRequired(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function getHttpMethod(): string
    {
        return 'POST';
    }

    /**
     * {@inheritDoc}
     */
    public function getEndpoint(): string
    {
        return 'user/login';
    }

    /**
     * {@inheritDoc}
     */
    public function getRequestData(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getParameters(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getParsedResponse(array $responseHeaders, array $responseData): ResponseInterface
    {
        return new LoginResponse($responseData);
    }
}
