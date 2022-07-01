<?php
/*
 * ErrorsFactory.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Lib\Errors;

class ErrorsFactory implements ErrorsFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createFromResponse(array $responseData): ErrorsInterface
    {
        $errors = [];

        foreach ($responseData['errors'] as $error) {
            $errors[] = new Error(
                $error['message'],
                $error['code'] ?? null,
                $error['level']
            );
        }

        return new Errors($errors);
    }
}
