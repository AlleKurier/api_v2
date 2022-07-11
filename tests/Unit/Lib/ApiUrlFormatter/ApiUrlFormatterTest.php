<?php
/*
 * ApiUrlFormatterTest.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

namespace AlleKurier\ApiV2Tests\Unit\Lib\Core\ApiUrlFormatter;

use AlleKurier\ApiV2\Command\RequestInterface;
use AlleKurier\ApiV2\Lib\ApiUrlFormatter\ApiUrlFormatter;
use AlleKurier\ApiV2\Lib\ApiUrlFormatter\ApiUrlFormatterInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ApiUrlFormatterTest extends TestCase
{
    private const TEST_API_URL = 'https://test.api.com';

    private ApiUrlFormatterInterface $apiUrlFormatter;

    /**
     * @var MockObject|RequestInterface
     */
    private MockObject $request;

    public function setUp(): void
    {
        $this->request = $this->createMock(RequestInterface::class);

        $this->apiUrlFormatter = new ApiUrlFormatter();
    }

    /**
     * @dataProvider getFormattedUrlProvider
     */
    public function test_get_formatted_url(
        string $endpoint,
        array  $parameters,
        string $expectedFormattedUrl
    ): void
    {
        $this->request
            ->method('getEndpoint')
            ->willReturn($endpoint);

        $this->request
            ->method('getParameters')
            ->willReturn($parameters);

        $formattedUrl = $this->apiUrlFormatter->getFormattedUrl(
            self::TEST_API_URL,
            $this->request
        );

        $this->assertEquals($expectedFormattedUrl, $formattedUrl);
    }

    public function getFormattedUrlProvider(): array
    {
        return [
            [
                'order/trackingnumber/12345678',
                [],
                self::TEST_API_URL . '/order/trackingnumber/12345678',
            ],
            [
                'order/trackingnumber/12345678',
                [
                    'a' => 1,
                    'b' => 'c',
                ],
                self::TEST_API_URL . '/order/trackingnumber/12345678/?a=1&b=c',
            ],
        ];
    }
}
