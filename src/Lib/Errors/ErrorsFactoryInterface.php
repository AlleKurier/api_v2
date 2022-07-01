<?php
/*
 * ErrorsFactoryInterface.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

namespace AlleKurier\ApiV2\Lib\Errors;

interface ErrorsFactoryInterface
{
    /**
     * Utworzenie obiektu z błędami na podstawie odpowiedzi
     *
     * @param array $responseData
     * @return ErrorsInterface
     */
    public function createFromResponse(array $responseData): ErrorsInterface;
}
