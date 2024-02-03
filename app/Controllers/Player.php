<?php

namespace App\Controllers;

use App\Models\PlayerModel;
use App\Models\LeagueModel;
use App\Models\LeaguePlayerMappingModel;
use CodeIgniter\Controller;

class Player extends Controller
{
    public function Player()
    {
        $playerModel = new PlayerModel();
        $data['players'] = $playerModel->findAll();

        $leagueModel = new LeagueModel();
        $data['leagues'] = $leagueModel->findAll(); 

        return view('Player', $data);
    }

    public function addPlayerAndMapToLeague()
    {
        $playerModel = new PlayerModel();
        $mappingModel = new LeaguePlayerMappingModel();

        // Sample data, replace with actual form input data
        $playerData = [
            'name' => $this->request->getPost('name'),
            'Date_of_birth' => $this->request->getPost('dateOfBirth'),
            'firstname' => $this->request->getPost('firstname'),
            'lastname' => $this->request->getPost('lastname'),
            // ... Add other player data
        ];

        // Insert player data
        $playerId = $playerModel->insert($playerData);

        // Handle image upload
        $imageData = $this->request->getPost('image');

        if (!empty($imageData)) {
            // Decode base64-encoded image data
            $decodedImage = base64_decode($imageData);

            // Check if decoding was successful
            if ($decodedImage === false) {
                return $this->handleError('Invalid image data');
            }

            // Get the MIME type of the image (assuming it's a JPEG, you may need to adjust accordingly)
            $mime = finfo_buffer(finfo_open(), $decodedImage, FILEINFO_MIME_TYPE);

            // Check if MIME type is valid (you may need to adjust this based on your allowed types)
            if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif'])) {
                return $this->handleError('Invalid image format');
            }

            // Update the 'image' field in the player record with the base64-encoded image data
            $playerModel->update($playerId, ['image' => $imageData]);
        }

        // Sample league ID, replace with actual form input or dynamic data
        $leagueId = $this->request->getPost('league_id');

        // Map player to league
        $mappingData = [
            'playerId' => $playerId,
            'leagueId' => $leagueId,
        ];

        $mappingModel->insert($mappingData);

        // Check if the request is AJAX
        if ($this->request->isAJAX()) {
            return $this->handleSuccess('Player added successfully');
        } else {
            return redirect()->to('addleague')->with('success', 'Player added successfully');
        }
    }

    private function handleError($message)
    {
        if ($this->request->isAJAX()) {
            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        } else {
            return redirect()->to('addleague')->with('error', $message);
        }
    }

    private function handleSuccess($message)
    {
        if ($this->request->isAJAX()) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        } else {
            return redirect()->to('addleague')->with('success', $message);
        }
    }






    // New method to handle player addition
   
}
