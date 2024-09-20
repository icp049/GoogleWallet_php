<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Firebase\JWT\JWT;
use Laminas\Math\Rand;


try {
    $walletPass = new WalletPass('config/walletconfig.json');
    echo $walletPass->createPassObject();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}



class WalletPass {
    private $credentials;
    private $client;
    private $baseUrl = 'https://walletobjects.googleapis.com/walletobjects/v1';
    private $issuerId = '3388000000022754147';
    private $classId;

    public function __construct($credentialsPath) {
        $this->credentials = json_decode(file_get_contents($credentialsPath), true);
        $this->client = new Client();
        $this->classId = $this->issuerId . '.meins';
    }

    private function getAuthToken() {
        $tokenUri = 'https://oauth2.googleapis.com/token';

        $jwt = JWT::encode([
            'iss' => $this->credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/wallet_object.issuer',
            'aud' => $tokenUri,
            'exp' => time() + 3600,
            'iat' => time()
        ], $this->credentials['private_key'], 'RS256');

        $response = $this->client->post($tokenUri, [
            'form_params' => [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['access_token'];
    }

    private function formatCodabar($accountNumber) {
        return 'A' . $accountNumber . 'A';
    }

    public function createPassObject() {
        $len = 4;
        $randomBytes = Rand::getBytes($len);
        $randomNumber = hexdec(bin2hex($randomBytes));

        $randomNumber = 1000 + ($randomNumber % 9000);      
        $objectId = "{$this->issuerId}.{$randomNumber}"; 

        $form_accountNumber = htmlspecialchars($_POST['form_accountNumber']);
        $form_firstName = htmlspecialchars($_POST['form_firstName']);
        $form_lastName = htmlspecialchars($_POST['form_lastName']);

        $accountNumber = $form_accountNumber;
        $codabar = $this->formatCodabar($accountNumber);
        $firstName = $form_firstName;
        $lastName = $form_lastName;

        $genericObject = [
            'id' => $objectId,
            'classId' => $this->classId,
            'genericType' => 'GENERIC_TYPE_UNSPECIFIED',
            "state" => "ACTIVE",
            'logo' => [
                'sourceUri' => [
                    'uri' => ''
                ]
            ],
            'cardTitle' => [
                'defaultValue' => [
                    'language' => 'en',
                    'value' => '1'
                ]
            ],
            'header' => [
                'defaultValue' => [
                    'language' => 'en',
                    'value' => $firstName . ' ' . $lastName
                ]
            ],
            'barcode' => [
                'type' => 'CODABAR',
                'value' => $codabar,
                'alternateText' => $accountNumber
            ],
            'hexBackgroundColor' => '#6e3acf',
            'heroImage' => [
                'sourceUri' => [
                    'uri' => ''
                ],
                'contentDescription' => [
                    'defaultValue' => [
                        'language' => 'en-US',
                        'value' => 'HERO_IMAGE_DESCRIPTION'
                    ]
                ]
            ]
        ];

        $claims = [
            'iss' => $this->credentials['client_email'],
            'aud' => 'google',
            'origins' => [],
            'typ' => 'savetowallet',
            'payload' => [
                'genericObjects' => [$genericObject]
            ]
        ];

        $token = JWT::encode($claims, $this->credentials['private_key'], 'RS256');

        $host = "pay.google.com";
        $saveUrl = "https://{$host}/gp/v/save/{$token}";

        return $saveUrl;
    }
}

$allowedOrigins = 'https://pay.google.com';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Access-Control-Allow-Origin: $allowedOrigins");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    $walletPass = new WalletPass('config/walletconfig.json');

    echo $walletPass->createPassObject();
}
?>