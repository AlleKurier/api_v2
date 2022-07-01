<?php
/*
 * AbstractResponse.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Command;

abstract class AbstractResponse implements ResponseInterface
{
    /**
     * {@inheritDoc}
     */
    public function hasErrors(): bool
    {
        return false;
    }
}
