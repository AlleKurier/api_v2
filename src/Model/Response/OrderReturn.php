<?php
/*
 * Return.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Model\Response;

class OrderReturn implements ResponseModelInterface
{
    private AdditionalFields $additionalFields;

    /**
     * Konstruktor
     *
     * @param AccessPoint|null $accessPoint
     */
    public function __construct(
        AdditionalFields $additionalFields
    )
    {
        $this->additionalFields = $additionalFields;
    }

    /**
     * {@inheritDoc}
     */
    public static function createFromArray(array $data): self
    {
        $additionalFields = AdditionalFields::createFromArray(!empty($data['additional_fields'])
            ? $data['additional_fields']
            : []);

        return new self(
            $additionalFields
        );
    }

    /**
     * Pobranie numeru zamówienia jeżeli istnieje
     *
     * @return string|null
     */
    public function getNumber(): ?string
    {
        $orderNumber = $this->getAdditionalFields()->findByName('orderNumber');

        return !is_null($orderNumber)
            ? $orderNumber->getValue()
            : null;
    }

    /**
     * Pobranie dodatkowych pól opisujących przesyłkę
     *
     * @return AdditionalFields
     */
    public function getAdditionalFields(): AdditionalFields
    {
        return $this->additionalFields;
    }
}
