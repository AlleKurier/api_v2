<?php
/*
 * ResponseParserTest.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

namespace AlleKurier\ApiV2Tests\Unit\Lib\Core\ResponseParser;

use AlleKurier\ApiV2\Command\RequestInterface;
use AlleKurier\ApiV2\Command\ResponseInterface;
use AlleKurier\ApiV2\Lib\Errors\ErrorsFactoryInterface;
use AlleKurier\ApiV2\Lib\Errors\ErrorsInterface;
use AlleKurier\ApiV2\Lib\ResponseParser\ResponseParser;
use AlleKurier\ApiV2\Lib\ResponseParser\ResponseParserInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ResponseParserTest extends TestCase
{
    private ResponseParserInterface $responseParser;

    /**
     * @var MockObject|ErrorsFactoryInterface
     */
    private MockObject $errorsFactory;

    /**
     * @var MockObject|RequestInterface
     */
    private MockObject $request;

    /**
     * @var MockObject|ResponseInterface
     */
    private MockObject $response;

    /**
     * @var MockObject|ErrorsInterface
     */
    private MockObject $errors;

    public function setUp(): void
    {
        $this->errorsFactory = $this->createMock(ErrorsFactoryInterface::class);
        $this->request = $this->createMock(RequestInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->errors = $this->createMock(ErrorsInterface::class);

        $this->responseParser = new ResponseParser($this->errorsFactory);
    }

    public function test_get_parsed_response(): void
    {
        $responseHeaders = [
            'Test-Header' => 'Test',
        ];

        $responseData = [
            'success' => true,
            'failure' => false,
            'a' => 1,
            'b' => 'c',
        ];

        $this->request
            ->expects(self::once())
            ->method('getParsedResponse')
            ->with($responseHeaders, $responseData)
            ->willReturn($this->response);

        $parsedResponse = $this->responseParser->getParsedResponse(
            $this->request,
            $responseHeaders,
            $responseData
        );

        $this->assertSame($this->response, $parsedResponse);
    }

    public function test_get_parsed_response_with_errors(): void
    {
        $responseHeaders = [
            'Test-Header' => 'Test',
        ];

        $responseData = [
            'success' => false,
            'failure' => true,
            'a' => 1,
            'b' => 'c',
        ];

        $this->errorsFactory
            ->expects(self::once())
            ->method('createFromResponse')
            ->with($responseData)
            ->willReturn($this->errors);

        $parsedResponse = $this->responseParser->getParsedResponse(
            $this->request,
            $responseHeaders,
            $responseData
        );

        $this->assertSame($this->errors, $parsedResponse);
    }
}
