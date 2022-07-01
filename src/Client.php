<?php
/*
 * Client.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\WygodneZwroty\Api;

use AlleKurier\ApiV2\Command\RequestInterface;
use AlleKurier\ApiV2\Command\ResponseInterface;
use AlleKurier\ApiV2\Lib\Api\Api;
use AlleKurier\ApiV2\Lib\Api\ApiException;
use AlleKurier\ApiV2\Lib\ApiUrlFormatter\ApiUrlFormatter;
use AlleKurier\ApiV2\Lib\Authorization\Authorization;
use AlleKurier\ApiV2\Lib\Errors\ErrorsFactory;
use AlleKurier\ApiV2\Lib\ResponseParser\ResponseParser;
use Psr\Http\Client\ClientExceptionInterface;

class Client
{
    private const API_URL = 'https://api.allekurier.pl/v1';

    private Api $api;

    /**
     * Konstruktor
     *
     * @param Credentials $credentials
     */
    public function __construct(Credentials $credentials)
    {
        $httpClient = new \GuzzleHttp\Client();
        $apiUrlFormatter = new ApiUrlFormatter();
        $authorization = new Authorization();
        $errorsFactory = new ErrorsFactory();
        $responseParser = new ResponseParser($errorsFactory);

        $this->api = new Api(
            $httpClient,
            $apiUrlFormatter,
            $authorization,
            $responseParser,
            $credentials,
            $this->getApiUrl()
        );
    }

    /**
     * Pobranie adresu API
     *
     * @return string
     */
    public function getApiUrl(): string
    {
        return self::API_URL;
    }

    /**
     * Wywołanie komendy API
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws ApiException
     * @throws ClientExceptionInterface
     */
    public function call(RequestInterface $request): ResponseInterface
    {
        return $this->api->call($request);
    }
}
