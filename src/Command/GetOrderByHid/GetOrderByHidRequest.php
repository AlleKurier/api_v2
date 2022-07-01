<?php

namespace AlleKurier\ApiV2\Command\GetOrderByHid;

use AlleKurier\ApiV2\Command\RequestInterface;
use AlleKurier\ApiV2\Command\ResponseInterface;

class GetOrderByHidRequest implements RequestInterface
{
    private string $orderHid;

    public function __construct(string $orderHid)
    {
        $this->orderHid = $orderHid;
    }

    public function getOrderHid(): string
    {
        return $this->orderHid;
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
        return sprintf('order/%s', $this->orderHid);
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
        return new GetOrderByHidResponse($responseData);
    }
}
