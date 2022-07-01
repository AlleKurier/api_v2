<?php
/*
 * AdditionalFields.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Model\Response;

class AdditionalFields implements ResponseModelInterface
{
    private array $additionalFields;

    /**
     * Konstruktor
     *
     * @param array $additionalFields
     */
    public function __construct(
        array $additionalFields
    )
    {
        $this->additionalFields = $additionalFields;
    }

    /**
     * {@inheritDoc}
     */
    public static function createFromArray(array $data): self
    {
        $additionalFields = [];

        foreach ($data as $value) {
            $element = AdditionalField::createFromArray($value);

            $additionalFields[$element->getName()] = $element;
        }

        return new self(
            $additionalFields
        );
    }

    /**
     * Pobranie wszystkich dodatkowych pól
     *
     * @return AdditionalField[]
     */
    public function getAll(): array
    {
        return $this->additionalFields;
    }

    /**
     * Pobranie dodatkowego pola wg jego nazwy
     *
     * @param string $name
     * @return AdditionalField|null
     */
    public function findByName(string $name): ?AdditionalField
    {
        return $this->additionalFields[$name] ?? null;
    }
}
