<?php
/*
 * ResponseModelInterface.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

namespace AlleKurier\ApiV2\Model\Response;

interface ResponseModelInterface
{
    /**
     * Utworzenie danych na podstawie tablicy
     *
     * @param array $data
     * @return self
     */
    public static function createFromArray(array $data): self;
}
