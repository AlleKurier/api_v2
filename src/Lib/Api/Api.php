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

    private const HTTP_HEADER_MAILBOX_CODE = 'MailBox-Code';

    private ClientInterface $client;

    private ApiUrlFormatterInterface $apiUrlFormatter;

    private AuthorizationInterface $authorization;

    private ResponseParserInterface $responseParser;

    private ?Credentials $credentials;

    private string $apiUrl;

    /**
     * Konstruktor
     *
     * @param ClientInterface $client
     * @param ApiUrlFormatterInterface $apiUrlFormatter
     * @param AuthorizationInterface $authorization
     * @param ResponseParserInterface $responseParser
     * @param string $apiUrl
     * @param Credentials|null $credentials
     */
    public function __construct(
        ClientInterface          $client,
        ApiUrlFormatterInterface $apiUrlFormatter,
        AuthorizationInterface   $authorization,
        ResponseParserInterface  $responseParser,
        string                   $apiUrl,
        ?Credentials             $credentials
    )
    {
        $this->client = $client;
        $this->apiUrlFormatter = $apiUrlFormatter;
        $this->authorization = $authorization;
        $this->responseParser = $responseParser;
        $this->apiUrl = $apiUrl;
        $this->credentials = $credentials;
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
        $httpRequest = $this->buildHttpRequest($request);
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

    /**
     * Zbudowanie zapytania HTTP
     *
     * @param RequestInterface $request
     * @return Request
     * @throws ApiException
     */
    private function buildHttpRequest(RequestInterface $request): Request
    {
        if ($request->isCredentialsRequired()) {
            if (is_null($this->credentials)) {
                throw new ApiException('Credential are required.');
            }
        } else {
            if (!is_null($this->credentials)) {
                throw new ApiException('Credential should not be sent because they will not be used.');
            }
        }

        $url = $this->apiUrlFormatter->getFormattedUrl(
            $this->apiUrl,
            $request
        );

        $requestData = $request->getRequestData();
        $requestDataString = json_encode($requestData);

        $httpMethod = $request->getHttpMethod();

        $httpHeaders = $this->buildHttpRequestHeaders();

        return new Request(
            $httpMethod,
            $url,
            $httpHeaders,
            $requestDataString
        );
    }

    /**
     * Zbudowanie tablicy z nagłówkami do zapytania HTTP
     *
     * @return string[]
     */
    private function buildHttpRequestHeaders(): array
    {
        $httpHeaders = [
            'Content-Type' => 'application/json',
        ];

        if (!is_null($this->credentials)) {
            $authorizationHeader = $this->authorization->getHttpHeader($this->credentials->getToken());
            $httpHeaders[self::HTTP_HEADER_AUTHORIZATION] = $authorizationHeader;

            if ($this->credentials->isMailBoxCode()) {
                $httpHeaders[self::HTTP_HEADER_MAILBOX_CODE] = $this->credentials->getMailBoxCode();
            }
        }

        return $httpHeaders;
    }
}
