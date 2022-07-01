<?php
/*
 * GetOrderByTrackingNumberRequest.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Command\GetOrderByTrackingNumber;

use AlleKurier\ApiV2\Command\RequestInterface;
use AlleKurier\ApiV2\Command\ResponseInterface;

class GetOrderByTrackingNumberRequest implements RequestInterface
{
    private string $trackingNumber;

    /**
     * Konstruktor
     *
     * @param string $trackingNumber
     */
    public function __construct(string $trackingNumber)
    {
        $this->trackingNumber = $trackingNumber;
    }

    /**
     * Pobranie numeru śledzenia
     *
     * @return string
     */
    public function getTrackingNumber(): string
    {
        return $this->trackingNumber;
    }

    /**
     * {@inheritDoc}
     */
    public function getHttpMethod(): string
    {
        return 'GET';
    }

    /**
     * {@inheritDoc}
     */
    public function getEndpoint(): string
    {
        return sprintf('order/trackingnumber/%s', $this->trackingNumber);
    }

    /**
     * {@inheritDoc}
     */
    public function getRequestData(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getParameters(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getParsedResponse(array $responseHeaders, array $responseData): ResponseInterface
    {
        return new GetOrderByTrackingNumberResponse($responseData);
    }
}
