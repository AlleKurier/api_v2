<?php
/*
 * Country.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Model\Response;

class Country implements ResponseModelInterface
{
    private string $code;

    private string $name;

    /**
     * Konstruktor
     *
     * @param string $code
     * @param string $name
     */
    public function __construct(string $code, string $name)
    {
        $this->code = $code;
        $this->name = $name;
    }

    /**
     * {@inheritDoc}
     */
    public static function createFromArray(array $data): self
    {
        $code = $data['code'];
        $name = $data['name'];

        return new self(
            $code,
            $name
        );
    }

    /**
     * Pobranie kodu kraju
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Pobranie nazwy kraju
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
