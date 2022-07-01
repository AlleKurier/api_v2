<?php
/*
 * AccessPoint.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Model\Response;

class AccessPoint implements ResponseModelInterface
{
    private string $code;

    private ?string $name;

    private ?string $address;

    private ?string $postalCode;

    private ?string $city;

    private ?string $description;

    private ?string $openHours;

    /**
     * Konstruktor
     *
     * @param string $code
     * @param string|null $name
     * @param string|null $address
     * @param string|null $postalCode
     * @param string|null $city
     * @param string|null $description
     * @param string|null $openHours
     */
    public function __construct(
        string  $code,
        ?string $name,
        ?string $address,
        ?string $postalCode,
        ?string $city,
        ?string $description,
        ?string $openHours
    )
    {
        $this->code = $code;
        $this->name = $name;
        $this->address = $address;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->description = $description;
        $this->openHours = $openHours;
    }

    /**
     * {@inheritDoc}
     */
    public static function createFromArray(array $data): self
    {
        $code = $data['code'];
        $name = $data['name'] ?? null;
        $address = $data['address'] ?? null;
        $postalCode = $data['postal_code'] ?? null;
        $city = $data['city'] ?? null;
        $description = $data['description'] ?? null;
        $openHours = $data['open_hours'] ?? null;

        return new self(
            $code,
            $name,
            $address,
            $postalCode,
            $city,
            $description,
            $openHours
        );
    }

    /**
     * Pobranie kodu punktu
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Pobranie nazwy punktu
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Pobranie adresu punktu
     *
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * Pobranie kodu pocztowego punktu
     *
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * Pobranie miejscowości, w której znajduje się punkt
     *
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Pobranie opisu punktu
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Pobranie godzin otwarcia dla punktu
     *
     * @return string|null
     */
    public function getOpenHours(): ?string
    {
        return $this->openHours;
    }
}
