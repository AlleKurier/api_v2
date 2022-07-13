# Biblioteka kliencka API dla AlleKuriera i Wygodnych Zwrotów

[![Autor](http://img.shields.io/badge/author-allekurier.pl-blue.svg?style=flat-square)](https://allekurier.pl)
[![Licencja](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/AlleKurier/api_v2/blob/master/LICENSE.md)

## Wymagania

Biblioteka ma następujące wymagania:

* PHP 7.4 lub nowsza wersja;
* rozszerzenie "ext-curl" do PHP;
* rozszerzenie "ext-json" do PHP.

## Instalacja

W celu zainstalowania biblioteki należy użyć następującego polecenia:

```bash
composer require allekurier/api_v2
```

## Korzystanie z API

### Autoryzacja

#### Wygenerowanie tokenu

W celu korzystania z komend API należy najpierw się zalogować. Logowanie powoduje wygenerowanie tokenu, który następnie jest używany przy wywoływaniu każdej innej komendy.

Token jest ważny 2 tygodnie. Po tym czasie należy ponownie się zalogować.

##### Zapytanie

https://api.allekurier.pl/user/login

```json
{
    "email": "EMAIL_KLIENTA",
    "password": "HASLO_KLIENTA"
}
```

gdzie:

* `EMAIL_KLIENTA`: E-mail klienta, na który zarejestrowane jest jego konto.
* `HASLO_KLIENTA`: Hasło przypisane do konta klienta.

##### Odpowiedź

W odpowiedzi zwracanych jest parę pól z danymi, z których najważniejszymi są następujące:

* `token`: Token autoryzacyjny.

Przykład:

```json
{
    "failure": false,
    "successful": true,
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NTc1MzkwNzYsImV4cCI6MTY1ODc0ODY3Niwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImlkIjoxLCJoaWQiOiI1NmNlNmRhMC0yNDlkLTQyMTAtOGZjOC0zZDgxN2M2NTQ2ZDQiLCJ1c2VybmFtZSI6ImRvbWluaWsua29jdWpAYWxsZWt1cmllci5wbCJ9.MJxT7CYjPcNT2NYt22MQxXFZ1kKbUwacoXksBxwf-mjfJaf2Ukh2Pk98qwpDcte6jW48pQyozXQ8seiJDrGYHeBpUrX2tBLt7yVqVXAFJFBW-J6qTyIGZDgT-sUxdcsqqSZhofCuFSb_xbbdc_yFzHDmNzkXTylTM3p9tKGnSoqFFMN6n-BPhaW3vf6_Diht6BWtdDU51k8uUqsn-mjAgEB9Begzz5E2fO7NthroXHVC5EqFGIs2nfo3Oi7cqHWsIODbreFPd2lg4PaDiwi9GeCae8Ka7X1My0QLyAX_CDZ5uyTLWp8p0RgEtthELSpmCgXsZ-J785NUj40ROfaLZQ"
} 
```

##### PHP

```php
$api = new \AlleKurier\ApiV2\Client();
$request = new \AlleKurier\ApiV2\Command\User\Login\LoginRequest(
    'EMAIL_KLIENTA',
    'HASLO_KLIENTA'
);

/** @var \AlleKurier\ApiV2\Command\User\Login\LoginResponse|\AlleKurier\ApiV2\Lib\Errors\ErrorsInterface $response */
$response = $api->call($request);

if ($response->hasErrors()) {
    foreach ($response->getErrors() as $error) {
        echo $error->getMessage() . PHP_EOL;
        echo $error->getCode() . PHP_EOL;
        echo $error->getLevel() . PHP_EOL;
    }
} else {
    $loginData = $response->getLoginData();
}
```

gdzie:

* `EMAIL_KLIENTA`: E-mail klienta, na który zarejestrowane jest jego konto.
* `HASLO_KLIENTA`: Hasło przypisane do konta klienta.

Jeżeli nie zostały zwrócone błędy, to `$loginData` zawiera dane zwrócone w odpowiedzi. Obecnie jest to token autoryzacyjny, który można pobrać przy pomocy metody `getToken()`, tj.:

```php
$token = $loginData->getToken();
```

#### Używanie tokenu

W celu nawiązania połączenia z API należy podać token, który został wygenerowany poprzez wywołanie komendy do logowania.

Jeżeli klient jest właścicielem sklepu korzystającego z usługi Wygodnych Zwrotów, to może podać również kod sklepu, aby dla komend API, które z niego korzystają, uzyskać wyniki, które nie dotyczą konta klienta, ale wybranego sklepu.

Dane autoryzacyjne muszą znajdować się w nagłówku HTTP w postaci:

* `Authorization`: Musi być typu "BEARER" i zawierać token.
* `MailBox-Code`: Jeżeli istnieje, to musi zawierać kod sklepu, którego dotyczy wywołanie komendy.

W niniejszej bibliotece można te dane uzyskać wywołując następujący kod:

```php
$credentials = new AlleKurier\ApiV2\Credentials('TOKEN_AUTORYZACYJNY', 'KOD_SKLEPU_KLIENTA');
$api = new AlleKurier\ApiV2\Client($credentials);
```

gdzie:

* `TOKEN_AUTORYZACYJNY`: Token uzyskany po zalogowaniu przez klienta.
* `KOD_SKLEPU_KLIENTA`: Kod sklepu, dla którego ma zostać wywołana komenda API.

### Zwracane dane

Zwracane dane są zawsze w formacie JSON. W celu sprawdzenia czy nie wystąpił błąd można sprawdzić jeden z następujących elementów:

* `failure`: Jest ustawione na `true`, gdy zwrócony został błąd.
* `successful`: Jest ustawiony na `true`, gdy błąd nie wystąpił.

Oba elementy są zawsze zwracane w każdej odpowiedzi z API.

W przypadku wystąpienia błędu zwracane są następujące elementy:

* `errors`: Tablica błędów.
* `mainError`: Główny błąd.

Każdy z błędów - czy to w tablicy `errors` czy w kluczu `mainError` - zawiera następujące elementy:

* `message`: Opis błędu.
* `code`: Kod błędu. Może zwrócić wartość `null`.
* `level`: Poziom błędu: Dostępne są poziomy: `notice`, `warning`, `critical`.

Przykład:

```json
{
    "errors":[
        {
            "message":"Zam\u00f3wienie nie istnieje",
            "code":null,
            "level":"critical"
        }
    ],
    "mainError":{
        "message":"Zam\u00f3wienie nie istnieje",
        "code":null,
        "level":"critical"
    },
    "failure":true,
    "successful":false
}
```

### Komendy

Informacje o wszystkich dostępnych komendach znajdują się pod adresem: https://api.allekurier.pl/api/doc

#### Pobranie danych przesyłki

##### PHP

```php
$request = new AlleKurier\ApiV2\Command\GetOrderByTrackingNumber\GetOrderByTrackingNumberRequest(
    'NUMER_SLEDZENIA'
);

/** @var \AlleKurier\ApiV2\Command\Order\GetByTrackingNumber\GetByTrackingNumberResponse|\AlleKurier\ApiV2\Lib\Errors\ErrorsInterface $response */
$response = $api->call($request);

if ($response->hasErrors()) {
    foreach ($response->getErrors() as $error) {
        echo $error->getMessage() . PHP_EOL;
        echo $error->getCode() . PHP_EOL;
        echo $error->getLevel() . PHP_EOL;
    }
} else {
    if (!is_null($response->getOrder()->getOrderReturn())) {
        echo $response->getOrder()->getOrderReturn()->getNumber() . PHP_EOL;
    }
    echo $response->getOrder()->getHid() . PHP_EOL;
    echo $response->getOrder()->getUser()->getEmail() . PHP_EOL;
    echo $response->getOrder()->getSender()->getName() . PHP_EOL;
    echo $response->getOrder()->getSender()->getCompany() . PHP_EOL;
    echo $response->getOrder()->getSender()->getAddress() . PHP_EOL;
    echo $response->getOrder()->getSender()->getPostalCode() . PHP_EOL;
    echo $response->getOrder()->getSender()->getCity() . PHP_EOL;
    echo $response->getOrder()->getSender()->getCountry()->getCode() . PHP_EOL;
    echo $response->getOrder()->getSender()->getCountry()->getName() . PHP_EOL;
    echo $response->getOrder()->getSender()->getState() . PHP_EOL;
    echo $response->getOrder()->getSender()->getPhone() . PHP_EOL;
    echo $response->getOrder()->getSender()->getEmail() . PHP_EOL;
    if (!empty($response->getOrder()->getSender()->getAccessPoint())) {
        echo $response->getOrder()->getSender()->getAccessPoint()->getCode() . PHP_EOL;
        echo $response->getOrder()->getSender()->getAccessPoint()->getName() . PHP_EOL;
        echo $response->getOrder()->getSender()->getAccessPoint()->getAddress() . PHP_EOL;
        echo $response->getOrder()->getSender()->getAccessPoint()->getPostalCode() . PHP_EOL;
        echo $response->getOrder()->getSender()->getAccessPoint()->getCity() . PHP_EOL;
        echo $response->getOrder()->getSender()->getAccessPoint()->getDescription() . PHP_EOL;
        echo $response->getOrder()->getSender()->getAccessPoint()->getOpenHours() . PHP_EOL;
    }
    if (!is_null($response->getOrder()->getOrderReturn())) {
        foreach ($response->getOrder()->getOrderReturn()->getAdditionalFields()->getAll() as $additionalField) {
            echo
                '"' . $additionalField->getName() . '";' .
                '"' . $additionalField->getTitle() . '";' .
                '"' . $additionalField->getValue() . '";' .
                PHP_EOL;
        }
    }
}
```

gdzie:

* `NUMER_SLEDZENIA`: Numer śledzenia przesyłki lub numer, który został zeskanowany na liście przewozowym.

##### cURL

```bash
curl -X GET \
  https://api.allekurier.pl/order/trackingnumber/NUMER_SLEDZENIA \
  -H 'accept: application/json' \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json' \
  -H 'authorization: BEARER TOKEN_AUTORYZACYJNY'
```

gdzie:

* `TOKEN_AUTORYZACYJNY`: Token autoryzacyjny.
* `NUMER_SLEDZENIA`: Numer śledzenia przesyłki lub numer, który został zeskanowany na liście przewozowym.

#### Pobranie przesyłek wysłanych w danym dniu

##### PHP

```php
$request = new AlleKurier\ApiV2\Command\GetSentOrders\GetSentOrdersRequest(
    'DATA'
);

/** @var \AlleKurier\ApiV2\Command\Order\GetSentOrders\GetSentOrdersResponse|\AlleKurier\ApiV2\Lib\Errors\ErrorsInterface $response */
$response = $api->call($request);

if ($response->hasErrors()) {
    foreach ($response->getErrors() as $error) {
        echo $error->getMessage() . PHP_EOL;
        echo $error->getCode() . PHP_EOL;
        echo $error->getLevel() . PHP_EOL;
    }
} else {
    foreach ($response->getOrders() as $order) {
        if (!is_null($order->getOrderReturn())) {
            echo $order->getOrderReturn()->getNumber() . PHP_EOL;
        }
        echo $order->getHid() . PHP_EOL;
        echo $order->getStatus() . PHP_EOL;
        echo $order->getUser()->getEmail() . PHP_EOL;
        echo $order->getSender()->getName() . PHP_EOL;
        echo $order->getSender()->getCompany() . PHP_EOL;
        echo $order->getSender()->getAddress() . PHP_EOL;
        echo $order->getSender()->getPostalCode() . PHP_EOL;
        echo $order->getSender()->getCity() . PHP_EOL;
        echo $order->getSender()->getCountry()->getCode() . PHP_EOL;
        echo $order->getSender()->getCountry()->getName() . PHP_EOL;
        echo $order->getSender()->getState() . PHP_EOL;
        echo $order->getSender()->getPhone() . PHP_EOL;
        echo $order->getSender()->getEmail() . PHP_EOL;
        if (!empty($order->getSender()->getAccessPoint())) {
            echo $order->getSender()->getAccessPoint()->getCode() . PHP_EOL;
            echo $order->getSender()->getAccessPoint()->getName() . PHP_EOL;
            echo $order->getSender()->getAccessPoint()->getAddress() . PHP_EOL;
            echo $order->getSender()->getAccessPoint()->getPostalCode() . PHP_EOL;
            echo $order->getSender()->getAccessPoint()->getCity() . PHP_EOL;
            echo $order->getSender()->getAccessPoint()->getDescription() . PHP_EOL;
            echo $order->getSender()->getAccessPoint()->getOpenHours() . PHP_EOL;
        }
        if (!is_null($order->getOrderReturn())) {
            foreach ($order->getOrderReturn()->getAdditionalFields()->getAll() as $additionalField) {
                echo
                    '"' . $additionalField->getName() . '";' .
                    '"' . $additionalField->getTitle() . '";' .
                    '"' . $additionalField->getValue() . '";' .
                    PHP_EOL;
            }
        }
    }
}
```

gdzie:

* `DATA`: Data w formacie Y-m-d wg, której pobierana jest lista przesyłek. Gdy null- dzisiejsza data.

###### cURL

```bash
curl -X GET \
  https://api.allekurier.pl/order/sent?date=DATA \
  -H 'accept: application/json' \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json' \
  -H 'authorization: TOKEN_AUTORYZACYJNY'
```

gdzie:

* `TOKEN_AUTORYZACYJNY`: Token autoryzacyjny.
* `DATA`: Data w formacie Y-m-d wg, której pobierana jest lista przesyłek. Gdy null- dzisiejsza data.
