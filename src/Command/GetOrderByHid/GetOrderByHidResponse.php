<?php

namespace AlleKurier\ApiV2\Command\GetOrderByHid;

use AlleKurier\ApiV2\Command\AbstractResponse;
use AlleKurier\ApiV2\Command\ResponseInterface;
use AlleKurier\ApiV2\Model\Response\Order;

class GetOrderByHidResponse extends AbstractResponse implements ResponseInterface
{
    private Order $order;

    public function __construct(array $responseData)
    {
        $this->order = Order::createFromArray($responseData['order']);
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}
