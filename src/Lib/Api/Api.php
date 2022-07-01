<?php
/*
 * Api.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Lib\Api;

use AlleKurier\ApiV2\Command\RequestInterface;
use AlleKurier\ApiV2\Command\ResponseInterface;
use AlleKurier\ApiV2\Credentials;
use AlleKurier\ApiV2\Lib\ApiUrlFormatter\ApiUrlFormatterInterface;
use AlleKurier\ApiV2\Lib\Authorization\AuthorizationInterface;
use AlleKurier\ApiV2\Lib\ResponseParser\ResponseParserInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

class Api
{
    private const HTTP_HEADER_AUTHORIZATION = 'Authorization';

    private ClientInterface $client;

    private ApiUrlFormatterInterface $apiUrlFormatter;

    private AuthorizationInterface $authorization;

    private ResponseParserInterface $responseParser;

    private Credentials $credentials;

    private string $apiUrl;

    /**
     * Konstruktor
     *
     * @param ClientInterface $client
     * @param ApiUrlFormatterInterface $apiUrlFormatter
     * @param AuthorizationInterface $authorization
     * @param ResponseParserInterface $responseParser
     * @param Credentials $credentials
     * @param string $apiUrl
     */
    public function __construct(
        ClientInterface          $client,
        ApiUrlFormatterInterface $apiUrlFormatter,
        AuthorizationInterface   $authorization,
        ResponseParserInterface  $responseParser,
        Credentials              $credentials,
        string                   $apiUrl
    )
    {
        $this->client = $client;
        $this->apiUrlFormatter = $apiUrlFormatter;
        $this->authorization = $authorization;
        $this->responseParser = $responseParser;
        $this->credentials = $credentials;
        $this->apiUrl = $apiUrl;
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
        $url = $this->apiUrlFormatter->getFormattedUrl(
            $this->apiUrl,
            $this->credentials->getCode(),
            $request
        );

        $requestData = $request->getRequestData();
        $requestDataString = json_encode($requestData);

        $authorizationHeader = $this->authorization->getHttpHeader($this->credentials->getToken());

        $httpMethod = $request->getHttpMethod();

        $httpRequest = new Request(
            $httpMethod,
            $url,
            [
                'Content-Type' => 'application/json',
                self::HTTP_HEADER_AUTHORIZATION => $authorizationHeader,
            ],
            $requestDataString
        );

        $httpResponse = $this->client->sendRequest($httpRequest);

        $responseHeaders = $httpResponse->getHeaders();
        $responseBody = $httpResponse->getBody()->getContents();

        $responseData = json_decode($responseBody, true);
        if (is_null($responseData)) {
            throw new ApiException('Response data are not in JSON format.');
        }

        return $this->responseParser->getParsedResponse(
            $request,
            $responseHeaders,
            $responseData
        );
    }
}
