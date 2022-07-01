<?php
/*
 * Error.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Lib\Errors;

class Error
{
    private string $message;

    private ?string $code;

    private string $level;

    /**
     * Konstruktor
     *
     * @param string $message
     * @param string|null $code
     * @param string $level
     */
    public function __construct(string $message, ?string $code, string $level)
    {
        $this->message = $message;
        $this->code = $code;
        $this->level = $level;
    }

    /**
     * Pobranie opisu błędu
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Pobranie kodu błędu
     *
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Pobranie poziomu błędu
     *
     * @return string
     */
    public function getLevel(): string
    {
        return $this->level;
    }
}
