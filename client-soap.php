<?php
$client = new SoapClient(
    'http://127.0.0.1:8000/soap/patients?wsdl',
    ['trace' => true]
);

$result = $client->getPatients();
print_r($result);
