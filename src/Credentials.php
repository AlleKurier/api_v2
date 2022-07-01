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
    private string $code;

    private string $token;

    /**
     * Konstruktor
     *
     * @param string $code
     * @param string $token
     */
    public function __construct(string $code, string $token)
    {
        $this->code = $code;
        $this->token = $token;
    }

    /**
     * Pobranie kodu klienta
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
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
}
