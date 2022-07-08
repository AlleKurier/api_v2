<?php
/*
 * LoginData.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Model\Response;

class LoginData implements ResponseModelInterface
{
    private string $token;

    /**
     * Konstruktor
     *
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * {@inheritDoc}
     */
    public static function createFromArray(array $data): self
    {
        $token = $data['token'];

        return new self($token);
    }

    /**
     * Pobranie tokenu logowania
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
