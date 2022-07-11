<?php
/*
 * ApiTest.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

namespace AlleKurier\ApiV2Tests\Unit\Lib\Core\Api;

use AlleKurier\ApiV2\Command\RequestInterface;
use AlleKurier\ApiV2\Command\ResponseInterface;
use AlleKurier\ApiV2\Credentials;
use AlleKurier\ApiV2\Lib\Api\Api;
use AlleKurier\ApiV2\Lib\Api\ApiException;
use AlleKurier\ApiV2\Lib\ApiUrlFormatter\ApiUrlFormatterInterface;
use AlleKurier\ApiV2\Lib\Authorization\AuthorizationInterface;
use AlleKurier\ApiV2\Lib\ResponseParser\ResponseParserInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\StreamInterface;

class ApiTest extends TestCase
{
    private const TEST_API_URL = 'https://test.api.com';

    private Api $api;

    /**
     * @var MockObject|ClientInterface
     */
    private MockObject $client;

    /**
     * @var MockObject|ApiUrlFormatterInterface
     */
    private MockObject $apiUrlFormatter;

    /**
     * @var MockObject|AuthorizationInterface
     */
    private MockObject $authorization;

    /**
     * @var MockObject|ResponseParserInterface
     */
    private MockObject $responseParser;

    /**
     * @var MockObject|Credentials
     */
    private MockObject $credentials;

    /**
     * @var MockObject|RequestInterface
     */
    private MockObject $request;

    /**
     * @var MockObject|\Psr\Http\Message\ResponseInterface
     */
    private MockObject $httpResponse;

    /**
     * @var MockObject|StreamInterface
     */
    private MockObject $stream;

    /**
     * @var MockObject|ResponseInterface
     */
    private MockObject $response;

    public function setUp(): void
    {
        $this->client = $this->createMock(ClientInterface::class);
        $this->apiUrlFormatter = $this->createMock(ApiUrlFormatterInterface::class);
        $this->authorization = $this->createMock(AuthorizationInterface::class);
        $this->responseParser = $this->createMock(ResponseParserInterface::class);
        $this->credentials = $this->createMock(Credentials::class);

        $this->request = $this->createMock(RequestInterface::class);
        $this->httpResponse = $this->createMock(Response::class);
        $this->stream = $this->createMock(StreamInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);

        $this->api = new Api(
            $this->client,
            $this->apiUrlFormatter,
            $this->authorization,
            $this->responseParser,
            self::TEST_API_URL,
            $this->credentials
        );
    }

    /**
     * @throws ApiException
     * @throws ClientExceptionInterface
     */
    public function test_call_for_required_credentials_without_mailbox_code(): void
    {
        $this->callForTest(true, null);
    }

    /**
     * @throws ApiException
     * @throws ClientExceptionInterface
     */
    public function test_call_for_required_credentials_with_mailbox_code(): void
    {
        $this->callForTest(true, 'mailboxcode');
    }

    /**
     * @throws ApiException
     * @throws ClientExceptionInterface
     */
    public function test_call_for_not_required_credentials(): void
    {
        $this->callForTest(false, null);
    }

    /**
     * @throws ApiException
     * @throws ClientExceptionInterface
     */
    private function callForTest(bool $isCredentialsRequired, ?string $mailBoxCode): void
    {
        $credentialsToken = 'testtoken';
        $requestData = [];
        $httpAuthorizationHeader = 'BEARER ' . $credentialsToken;
        $httpMethod = 'GET';

        $formattedUrl = self::TEST_API_URL . '/order/trackingnumber/12345678';

        $responseHeaders = [];
        $responseBody = '{"errors":[],"mainError":{},"failure":false,"successful":true}';

        if (!$isCredentialsRequired) {
            $this->api = new Api(
                $this->client,
                $this->apiUrlFormatter,
                $this->authorization,
                $this->responseParser,
                self::TEST_API_URL,
                null
            );
        }

        if ($isCredentialsRequired) {
            $this->credentials
                ->method('getToken')
                ->willReturn($credentialsToken);

            $this->credentials
                ->method('isMailBoxCode')
                ->willReturn(!is_null($mailBoxCode));

            if (!is_null($mailBoxCode)) {
                $this->credentials
                    ->method('getMailBoxCode')
                    ->willReturn($mailBoxCode);
            }
        }

        $this->request
            ->method('isCredentialsRequired')
            ->willReturn($isCredentialsRequired);

        $this->apiUrlFormatter
            ->method('getFormattedUrl')
            ->with(self::TEST_API_URL, $this->request)
            ->willReturn($formattedUrl);

        $this->request
            ->method('getRequestData')
            ->willReturn($requestData);

        $this->request
            ->method('getHttpMethod')
            ->willReturn($httpMethod);

        $this->authorization
            ->method('getHttpHeader')
            ->with($credentialsToken)
            ->willReturn($httpAuthorizationHeader);

        $this->client
            ->method('sendRequest')
            ->willReturn($this->httpResponse);

        $this->httpResponse
            ->method('getHeaders')
            ->willReturn($responseHeaders);

        $this->httpResponse
            ->method('getBody')
            ->willReturn($this->stream);

        $this->stream
            ->method('getContents')
            ->willReturn($responseBody);

        $this->responseParser
            ->expects(self::once())
            ->method('getParsedResponse')
            ->with($this->request, $responseHeaders, json_decode($responseBody, true))
            ->willReturn($this->response);

        $response = $this->api->call(
            $this->request
        );

        $this->assertSame($this->response, $response);
    }
}
