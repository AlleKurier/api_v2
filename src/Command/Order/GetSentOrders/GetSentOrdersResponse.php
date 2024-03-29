<?php
/*
 * GetSentOrdersResponse.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Command\Order\GetSentOrders;

use AlleKurier\ApiV2\Command\AbstractResponse;
use AlleKurier\ApiV2\Command\ResponseInterface;
use AlleKurier\ApiV2\Model\Response\Order;

class GetSentOrdersResponse extends AbstractResponse implements ResponseInterface
{
    /**
     * @var Order[]
     */
    private array $orders;

    public function __construct(array $responseData)
    {
        $orders = [];

        foreach ($responseData['items'] as $order) {
            $orders[] = Order::createFromArray($order);
        }

        $this->orders = $orders;
    }

    /**
     * @return Order[]
     */
    public function getOrders(): array
    {
        return $this->orders;
    }
}
