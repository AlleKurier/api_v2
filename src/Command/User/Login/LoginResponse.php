<?php
/*
 * LoginResponse.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Command\User\Login;

use AlleKurier\ApiV2\Command\AbstractResponse;
use AlleKurier\ApiV2\Command\ResponseInterface;
use AlleKurier\ApiV2\Model\Response\LoginData;

class LoginResponse extends AbstractResponse implements ResponseInterface
{
    private LoginData $loginData;

    public function __construct(array $responseData)
    {
        $this->loginData = LoginData::createFromArray($responseData);
    }

    public function getLoginData(): LoginData
    {
        return $this->loginData;
    }
}
