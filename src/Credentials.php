<?php
/*
 * Credentials.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2;

class Credentials
{
    private string $token;

    private ?string $mailBoxCode;

    /**
     * Konstruktor
     *
     * @param string $code
     * @param string|null $mailBoxCode
     */
    public function __construct(string $token, ?string $mailBoxCode = null)
    {
        $this->token = $token;
        $this->mailBoxCode = $mailBoxCode;
    }

    /**
     * Pobranie tokena autoryzacyjnego
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Pobranie kodu skrzynki e-mail
     *
     * @return string|null
     */
    public function getMailBoxCode(): string
    {
        return $this->mailBoxCode;
    }
}
