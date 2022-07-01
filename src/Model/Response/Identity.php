<?php
/*
 * Identity.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Model\Response;

class Identity implements ResponseModelInterface
{
    private ?string $name;

    private ?string $company;

    private ?string $address;

    private ?string $postalCode;

    private ?string $city;

    private Country $country;

    private ?string $state;

    private ?string $phone;

    private ?string $email;

    private ?AccessPoint $accessPoint;

    /**
     * Konstruktor
     *
     * @param string|null $name
     * @param string|null $company
     * @param string|null $address
     * @param string|null $postalCode
     * @param string|null $city
     * @param Country $country
     * @param string|null $state
     * @param string|null $phone
     * @param string|null $email
     * @param AccessPoint|null $accessPoint
     */
    public function __construct(
        ?string      $name,
        ?string      $company,
        ?string      $address,
        ?string      $postalCode,
        ?string      $city,
        Country      $country,
        ?string      $state,
        ?string      $phone,
        ?string      $email,
        ?AccessPoint $accessPoint
    )
    {
        $this->name = $name;
        $this->company = $company;
        $this->address = $address;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->country = $country;
        $this->state = $state;
        $this->phone = $phone;
        $this->email = $email;
        $this->accessPoint = $accessPoint;
    }

    /**
     * {@inheritDoc}
     */
    public static function createFromArray(array $data): self
    {
        $name = $data['name'] ?? null;
        $company = $data['company'] ?? null;
        $address = $data['address'] ?? null;
        $postalCode = $data['postal_code'] ?? null;
        $city = $data['city'] ?? null;
        $country = Country::createFromArray($data['country']);
        $state = $data['state'] ?? null;
        $phone = $data['phone'] ?? null;
        $email = $data['email'] ?? null;
        $accessPoint = !empty($data['access_point'])
            ? AccessPoint::createFromArray($data['access_point'])
            : null;

        return new self(
            $name,
            $company,
            $address,
            $postalCode,
            $city,
            $country,
            $state,
            $phone,
            $email,
            $accessPoint
        );
    }

    /**
     * Pobranie nazwy osoby
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Pobranie nazwy firmy
     *
     * @return string|null
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * Pobranie adresu osoby/firmy
     *
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * Pobranie kodu pocztowego osoby/firmy
     *
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * Pobranie miejscowości dla osoby/firmy
     *
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Pobranie kraju dla osoby/firmy
     *
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * Pobranie stanu, w którym znajduje się kraj z osobą/firmą
     *
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * Pobranie numeru telefonu do osoby/firmy
     *
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Pobranie adresu e-mail osoby/firmy
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Pobranie punktu nadania/odbioru paczki
     *
     * @return AccessPoint|null
     */
    public function getAccessPoint(): ?AccessPoint
    {
        return $this->accessPoint;
    }
}
