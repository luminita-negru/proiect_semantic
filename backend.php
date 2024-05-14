<?php
header('Content-Type: application/json');

// Read JSON from request body
$jsonLD = file_get_contents('php://input');
$data = json_decode($jsonLD, true);
$unifiedData = [];

foreach ($data['@graph'][0]['veterinarian'] as $vet) {
    if (isset($vet['pets']) && count($vet['pets']) > 0) {
        foreach ($vet['pets'] as $pet) {
            $unifiedData[] = [
                'VeterinarianID' => $vet['VeterinarianID'],
                'name' => $vet['name'],
                'specialty' => $vet['specialty'],
                'petName' => $pet['name'],
                'petBreed' => $pet['breed']
            ];
        }
    } else {
        $unifiedData[] = [
            'VeterinarianID' => $vet['VeterinarianID'],
            'name' => $vet['name'],
            'specialty' => $vet['specialty'],
            'petName' => '',
            'petBreed' => ''
        ];
    }
}

echo json_encode($unifiedData);
?>