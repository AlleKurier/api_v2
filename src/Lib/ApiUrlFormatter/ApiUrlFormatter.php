<?php
/*
 * ApiUrlFormatter.php
 *
 * @author AlleKurier
 * @license https://opensource.org/licenses/MIT The MIT License
 * @copyright Copyright (c) 2022 Allekurier Sp. z o.o.
 */

declare(strict_types=1);

namespace AlleKurier\ApiV2\Lib\ApiUrlFormatter;

use AlleKurier\ApiV2\Command\RequestInterface;

class ApiUrlFormatter implements ApiUrlFormatterInterface
{
    /**
     * {@inheritDoc}
     */
    public function getFormattedUrl(string $apiUrl, string $authorizationCode, RequestInterface $request): string
    {
        $parameters = $request->getParameters();

        $parametersString = http_build_query($parameters);
        if (strlen($parametersString) > 0) {
            $parametersString = '?' . $parametersString;
        }

        $url = sprintf('%s/%s/%s/%s', $apiUrl, $authorizationCode, $request->getEndpoint(), $parametersString);

        return rtrim($url, '/');
    }
}
