<?php

include('vendor/autoload.php');

use GuzzleHttp\Client;

$cep = null;
$alert = null;
$response = 'Enter a valid 8 digit CEP and click Search button...';

if ($_GET['cep']) {
    $cep = preg_replace('/[^0-9]/', '', $_GET['cep']);

    if (strlen($cep) != 8) {
        $alert = 'Invalid CEP!';
    } else {
        $file = 'db/' . $cep . '.xml';

        if ( ! file_exists($file)) {
            try {
                $client = new Client([
                    'base_uri' => 'https://viacep.com.br/',
                ]);

                // sleep(5); // simulate slow connection

                $response = $client->request('GET', 'ws/' . $cep . '/xml')->getBody();

                if (strpos($response, '<erro>true</erro>') !== false) {
                    $alert = 'Invalid CEP!';
                    $response = null;
                } else {
                    file_put_contents($file, $response);
                }
            } catch (\Exception $e) {
                $alert = 'Invalid CEP!';
            }
        }

        if ( ! $alert) {
            $cep = substr($cep, 0, 5) . '-' . substr($cep, 5);
            $response = file_get_contents($file);
        }
    }
}

include('templates/index.html');
