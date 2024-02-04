<?php

namespace App\Controllers;

use App\Models\PlayerModel;
use App\Models\LeagueModel;
use App\Models\LeaguePlayerMappingModel;
use CodeIgniter\Controller;

class Player extends Controller
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function Player()
    {
        $playerModel = new PlayerModel();
        $data['players'] = $playerModel->findAll();

        $leagueModel = new LeagueModel();
        $data['leagues'] = $leagueModel->findAll(); 

        return view('Player', $data);
    }

    public function updatePlayerData()
    {
        $playerModel = new PlayerModel();
        $response = ['success' => false, 'message' => ''];

        // Get data from AJAX request
        $playerId = $this->request->getPost('id');
        $field = $this->request->getPost('field');
        $value = $this->request->getPost('value');

        // Validate data (add your validation rules)
        if (!isset($playerId) || !isset($field) || !isset($value)) {
            $response['message'] = 'Invalid input data.';
        } else {
            // Update player data in the database
            try {
                $playerModel->update($playerId, [$field => $value]);
                $response['success'] = true;
                $response['message'] = 'Player data saved.';
            } catch (\Exception $e) {
                $response['message'] = 'Failed to update player data.';
            }
        }

        return $this->response->setJSON($response);
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
        $imageData = $this->request->getFile('image');

        // Check if an image was uploaded
        if ($imageData->isValid() && !$imageData->hasMoved()) {
            // Read the image file and encode it as base64
            $base64Image = base64_encode(file_get_contents($imageData->getRealPath()));

            // Update the 'image' field in the player record with the base64-encoded image data
            $playerModel->update($playerId, ['image' => $base64Image]);
        }

        // Sample league ID, replace with actual form input or dynamic data
        $teamid = $this->request->getPost('teamid');

        // Map player to league
        $mappingData = [
            'playerId' => $playerId,
            'teamid' => $teamid,
        ];

        $mappingModel->insert($mappingData);

        // Debugging queries
        $lastQuery = $this->db->getLastQuery();
        echo $lastQuery;

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
