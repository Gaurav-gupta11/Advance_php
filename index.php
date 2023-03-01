<?php

require_once 'vendor/autoload.php'; // include Composer autoload file
use GuzzleHttp\Client;

// define the Service class with properties for id, title, description, and image_url
class Service {
    public $id;
    public $title;
    public $image_url;

    public function __construct($id, $title, $image_url) {
        $this->id = $id;
        $this->title = $title;
        $this->image_url = $image_url;
    }
}

// fetch the JSON data from the Innoraft API using GuzzleHttp
$client = new Client(['base_uri' => 'https://ir-dev-d9.innoraft-sites.com/']);
$response = $client->get('jsonapi/node/services');
$data = json_decode($response->getBody(), true);

// extract the relevant data from the JSON response and create Service objects
$services = array();
foreach ($data['data'] as $service) {
    $id = $service['id'];
    $title = $service['attributes']['title'];
    $uri_url = $service['relationships']['field_image']['links']['related']['href'];;
    
    // fetch the second JSON file using GuzzleHttp
    $response = $client->get($uri_url);
    $data = json_decode($response->getBody(), true);
    
    // extract the image URL from the second JSON file
    $image_url = $data['data']['attributes']['uri']['url'];
    $services[] = new Service($id, $title, $image_url);
}

// render the HTML page with the services displayed in a grid format
?>
<!DOCTYPE html>
<html>
<head>
    <title>Innoraft Services</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
       
    </style>
</head>
<body>
    <div class="container">
        <h1 style="text-align: center;">Innoraft Services</h1>
        <?php foreach ($services as $service): ?>
            <div class="service">
            <img src="https://ir-dev-d9.innoraft-sites.com<?php echo $service->image_url; ?>" alt="<?php echo $service->title; ?>">
                <h2><?php echo $service->title; ?></h2>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
