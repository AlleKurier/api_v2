<?php
/*
 * ResponseParserInterface.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

namespace AlleKurier\ApiV2\Lib\ResponseParser;

use AlleKurier\ApiV2\Command\RequestInterface;
use AlleKurier\ApiV2\Command\ResponseInterface;

interface ResponseParserInterface
{
    /**
     * Pobranie przetworzonej odpowiedzi dla komendy API w oparciu o nagłówki i dane odpowiedzi
     *
     * @param RequestInterface $request
     * @param array $responseHeaders
     * @param array $responseData
     * @return ResponseInterface
     */
    public function getParsedResponse(
        RequestInterface $request,
        array            $responseHeaders,
        array            $responseData
    ): ResponseInterface;
}
