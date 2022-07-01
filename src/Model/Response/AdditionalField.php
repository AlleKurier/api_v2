<?php
/*
 * AdditionalField.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Model\Response;

class AdditionalField implements ResponseModelInterface
{
    private string $name;

    private string $title;

    private string $value;

    /**
     * Konstruktor
     *
     * @param string $name
     * @param string $title
     * @param string $value
     */
    public function __construct(string $name, string $title, string $value)
    {
        $this->name = $name;
        $this->title = $title;
        $this->value = $value;
    }

    /**
     * {@inheritDoc}
     */
    public static function createFromArray(array $data): self
    {
        $name = $data['name'];
        $title = $data['title'];
        $value = $data['value'];

        return new self(
            $name,
            $title,
            $value
        );
    }

    /**
     * Pobranie nazwy dodatkowego pola
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Pobranie tytułu dodatkowego pola
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Pobranie wartości dodatkowego pola
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
