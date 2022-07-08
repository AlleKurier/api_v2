<?php
/*
 * GetOrderByTrackingNumberResponse.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Command\Order\GetByTrackingNumber;

use AlleKurier\ApiV2\Command\AbstractResponse;
use AlleKurier\ApiV2\Command\ResponseInterface;
use AlleKurier\ApiV2\Model\Response\Order;

class GetByTrackingNumberResponse extends AbstractResponse implements ResponseInterface
{
    private Order $order;

    /**
     * Konstruktor
     *
     * @param array $responseData
     */
    public function __construct(array $responseData)
    {
        $this->order = Order::createFromArray($responseData['order']);
    }

    /**
     * Pobranie danych przesyłki
     *
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }
}
