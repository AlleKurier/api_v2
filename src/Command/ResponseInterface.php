<?php
/*
 * ResponseInterface.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

namespace AlleKurier\ApiV2\Command;

interface ResponseInterface
{
    /**
     * Check if response has errors
     *
     * @return bool
     */
    public function hasErrors(): bool;
}
