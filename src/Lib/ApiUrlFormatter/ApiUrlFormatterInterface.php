<?php
/*
 * ApiUrlFormatterInterface.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

namespace AlleKurier\ApiV2\Lib\ApiUrlFormatter;

use AlleKurier\ApiV2\Command\RequestInterface;

interface ApiUrlFormatterInterface
{
    /**
     * Pobranie sformatowanego adresu API w oparciu o adres API, kod autoryzacyjny oraz dane zapytania
     *
     * @param string $apiUrl
     * @param string $authorizationCode
     * @param RequestInterface $request
     * @return string
     */
    public function getFormattedUrl(string $apiUrl, string $authorizationCode, RequestInterface $request): string;
}
