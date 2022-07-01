<?php
/*
 * User.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Model\Response;

class User implements ResponseModelInterface
{
    private string $email;

    /**
     * Konstruktor
     *
     * @param string $email
     */
    private function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * {@inheritDoc}
     */
    public static function createFromArray(array $data): self
    {
        $email = $data['email'];

        return new self(
            $email
        );
    }

    /**
     * Pobranie adresu e-mail użytkownika
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
