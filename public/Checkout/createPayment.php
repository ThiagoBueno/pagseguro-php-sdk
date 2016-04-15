<?php

require_once "../../vendor/autoload.php";

\PagSeguro\Library::initialize();
\PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
\PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");

$payment = new \PagSeguro\Domains\Requests\Payment();

$payment->addItems()->withParameters(
    '0001',
    'Notebook prata',
    2,
    130.00
);

$payment->addItems()->withParameters(
    '0002',
    'Notebook preto',
    2,
    430.00
);

$payment->setCurrency("BRL");
$payment->setReference("LIBPHP000001");

$payment->setRedirectUrl("http://www.lojamodelo.com.br");

$payment->setSender()->withParameters(
    'João Comprador',
    'email@comprador.com.br',
    '11',
    '56273440',
    'CPF',
    '156.009.442-76'
);

$payment->setShipping()->setAddress()->withParameters(
    '01452002',
    'Av. Brig. Faria Lima',
    '1384',
    'apto. 114',
    'Jardim Paulistano',
    'São Paulo',
    'SP',
    'BRA'
);
$payment->setShipping()->setCost()->withParameters(20.00);
$payment->setShipping()->setType()->withParameters(\PagSeguro\Enum\Shipping\Type::SEDEX);

//Add metadata items
$payment->addMetadata()->withParameters('PASSENGER_CPF', '11111111111');
$payment->addMetadata()->withParameters('GAME_NAME', 'DOTA');
$payment->addMetadata()->withParameters('PASSENGER_PASSPORT', '23456', 1);

//Add items by parameter
$payment->addParameter()->withParameters('itemId', '0003')->index(3);
$payment->addParameter()->withParameters('itemDescription', 'Notebook Rosa')->index(3);
$payment->addParameter()->withParameters('itemQuantity', '1')->index(3);
$payment->addParameter()->withParameters('itemAmount', '200.00')->index(3);

//Add items by parameter using an array
$payment->addParameter()->withArray(['notificationURL', 'http://www.lojamodelo.com.br/nofitication']);


$payment->setRedirectUrl("http://www.lojamodelo.com.br");
$payment->setNotificationUrl("http://www.lojamodelo.com.br/nofitication");

try {
    $result = $payment->register(
        \PagSeguro\Configuration\Configure::getAccountCredentials()
    );
    echo "<h2>Criando requisi&ccedil;&atilde;o de pagamento</h2>"
        . "<p>URL do pagamento: <strong>$result</strong></p>"
        . "<p><a title=\"URL do pagamento\" href=\"$result\" target=\_blank\">Ir para URL do pagamento.</a></p>";
} catch (Exception $e) {
    die($e->getMessage());
}