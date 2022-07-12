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

    private ?OrderReturn $orderReturn;

    /**
     * Konstruktor
     *
     * @param string $hid
     * @param User $user
     * @param Identity $sender
     * @param string $status
     * @param OrderReturn|null $orderReturn
     */
    private function __construct(
        string   $hid,
        User     $user,
        Identity $sender,
        string   $status,
        ?OrderReturn $orderReturn
    )
    {
        $this->hid = $hid;
        $this->user = $user;
        $this->sender = $sender;
        $this->status = $status;
        $this->orderReturn = $orderReturn;
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
        $orderReturn = !empty($data['return'])
            ? OrderReturn::createFromArray($data['return'])
            : null;

        return new self(
            $hid,
            $user,
            $sender,
            $status,
            $orderReturn
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
     * Pobranie danych przesyłki zwrotnej
     *
     * @return OrderReturn|null
     */
    public function getOrderReturn(): ?OrderReturn
    {
        return $this->orderReturn;
    }
}
