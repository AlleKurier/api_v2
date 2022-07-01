<?php

namespace AlleKurier\ApiV2\Command\GetOrderLabels;

use AlleKurier\ApiV2\Command\AbstractResponse;
use AlleKurier\ApiV2\Command\ResponseInterface;

class GetOrderLabelsResponse extends AbstractResponse implements ResponseInterface
{
    private string $labelsContent;

    public function __construct(array $responseData)
    {
        $this->labelsContent = $responseData['labelsContent'];
    }

    public function getLabelsContent(): string
    {
        return $this->labelsContent;
    }
}
