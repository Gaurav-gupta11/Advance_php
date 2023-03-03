<?php
require_once 'vendor/autoload.php';
use GuzzleHttp\Client;

/**
 * Provides a service object.
 *
 * @param string $image_url
 *   The URL of the service's image.
 * @param array $icons
 *   An array of icons for the service.
 * @param string $fieldsecondary
 *   The value of the service's secondary field.
 * @param string $fieldservice
 *   The value of the service's primary field.
 */
class Service {
    /**
     * The URL of the service's image.
     *
     * @var string
     */
    public $image_url;
  
    /**
     * An array of icons for the service.
     *
     * @var array
     */
    public $icons;
  
    /**
     * The value of the service's secondary field.
     *
     * @var string
     */
    public $fieldsecondary;
  
    /**
     * The value of the service's primary field.
     *
     * @var string
     */
    public $fieldservice;
  
    /**
     * Constructs a Service object.
     *
     * @param string $image_url
     *   The URL of the service's image.
     * @param array $icons
     *   An array of icons for the service.
     * @param string $fieldsecondary
     *   The value of the service's secondary field.
     * @param string $fieldservice
     *   The value of the service's primary field.
     */
    public function __construct($image_url, $icons, $fieldsecondary, $fieldservice) {
        // Assign the values passed in to the corresponding properties
        $this->image_url = $image_url;
        $this->icons = $icons;
        $this->fieldsecondary = $fieldsecondary;
        $this->fieldservice = $fieldservice;
    }

     /**
     * Retrieves the service data from the API.
     *
     * @return array An array of Service objects.
     */
    public function getServiceData(): array
    {
        // Initialize a GuzzleHttp\Client object with the base URI
        $client = new Client(['base_uri' => 'https://ir-dev-d9.innoraft-sites.com/']);
        
        // Send a GET request to retrieve the service data
        $response = $client->get('jsonapi/node/services');
        
        // Decode the response body to a PHP array
        $data = json_decode($response->getBody(), true);

        // Initialize an empty array to hold the Service objects
        $services = [];

        // Get the last four services from the data array
        $last_four = array_slice($data['data'], -4);

        // Loop through each service in the $last_four array
        for ($i = 0; $i < count($last_four); $i++) {
            // Get the current service
            $service = $last_four[$i];

            // Initialize variables to hold the image URL, icons, and field values
            // Initialize the image URL variable  FT2023-72_Task7

            // Initialize the icons array
            $icons = [];
            // Get the URL for the service's image data
            $uri_url = $service['relationships']['field_image']['links']['related']['href']; 
            // Get the URL for the service's icon data
            $iconuri_url = $service['relationships']['field_service_icon']['links']['related']['href']; 
            // Get the service's secondary title
            $fieldsecondary = $service['attributes']['field_secondary_title']['processed']; 
            // Get the service's description
            $fieldservice = $service['attributes']['field_services']['processed']; 

            // Send a GET request to retrieve the image data
            $response = $client->get($uri_url);
            $data = json_decode($response->getBody(), true);

            // Check if the response contains the image URL
            if(isset($data['data']['attributes']['uri']['url'])) {
                $image_url = $data['data']['attributes']['uri']['url'];
            }

            // Send a GET request to retrieve the icon data
            $response = $client->get($iconuri_url);
            $data = json_decode($response->getBody(), true);

            // Loop through the icon data and extract the URLs of the thumbnails
            for ($j=0; $j<count($data['data']); $j++) {
                // Check if the thumbnail URL is available
                if(isset($data['data'][$j]['relationships']['thumbnail']['links']['related']['href'])) {
                    // Send a GET request to retrieve the thumbnail data
                    $thumbnailuri_url = $data['data'][$j]['relationships']['thumbnail']['links']['related']['href'];
                    $response = $client->get($thumbnailuri_url);
                    $data2 = json_decode($response->getBody(), true);

                    // Check if the response contains the thumbnail URL
                    if(isset($data2['data']['attributes']['uri']['url'])) {
                        // Add the thumbnail URL to the list of icons for this service
                        $icons[] = $data2['data']['attributes']['uri']['url'];
                    }
                }
            }

            // Create a new Service object with the retrieved data and add it to the services array
            $services[] = new Service($image_url, $icons, $fieldsecondary, $fieldservice);
        }

			return $services;
    }
}

$service = new Service($image_url, $icons, $fieldsecondary, $fieldservice);
$services = $service->getServiceData();

?>
