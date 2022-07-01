<?php
/*
 * Order.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Model\Response;

class Order implements ResponseModelInterface
{
    private string $hid;

    private User $user;

    private Identity $sender;

    private string $status;

    private AdditionalFields $additionalFields;

    /**
     * Konstruktor
     *
     * @param string $hid
     * @param User $user
     * @param Identity $sender
     * @param AdditionalFields $additionalFields
     */
    private function __construct(
        string $hid,
        User $user,
        Identity $sender,
        string $status,
        AdditionalFields $additionalFields
    ) {
        $this->hid = $hid;
        $this->user = $user;
        $this->sender = $sender;
        $this->status = $status;
        $this->additionalFields = $additionalFields;
    }

    /**
     * {@inheritDoc}
     */
    public static function createFromArray(array $data): self
    {
        $hid = $data['hid'];
        $user = User::createFromArray($data['user']);
        $sender = Identity::createFromArray($data['sender']);
        $status = $data['status'];
        $additionalFields = AdditionalFields::createFromArray(!empty($data['additional_fields'])
            ? $data['additional_fields']
            : []);

        return new self(
            $hid,
            $user,
            $sender,
            $status,
            $additionalFields
        );
    }

    /**
     * Pobranie identyfikatora przesyłki
     *
     * @return string
     */
    public function getHid(): string
    {
        return $this->hid;
    }

    /**
     * Pobranie numeru zamówienia jeżeli istnieje
     *
     * @return string|null
     */
    public function getNumber(): ?string
    {
        $orderNumber = $this->additionalFields->findByName('orderNumber');

        return !is_null($orderNumber)
            ? $orderNumber->getValue()
            : null;
    }

    /**
     * Pobranie danych użytkownika, do którego należy przesyłka
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Pobranie danych nadawcy przesyłki
     *
     * @return Identity
     */
    public function getSender(): Identity
    {
        return $this->sender;
    }

    /**
     * Pobranie statusu zamówienia
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
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
