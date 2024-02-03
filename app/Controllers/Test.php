<?php

namespace App\Controllers;

use App\Models\LeagueModel;
use App\Models\TeamModel;
use App\Models\PlayerModel;
use App\Models\LeaguePlayerMappingModel;
use CodeIgniter\Controller;


class Test extends Controller
{
    public function Test()
    {
        $leagueModel = new LeagueModel();
        $teamModel = new TeamModel();
    
        $leagues = $leagueModel->where('isactive', 1)->findAll();
    
        foreach ($leagues as &$league) {
            $league['teams'] = $teamModel->where('leagueid', $league['id'])->findAll();
        }
    
        $data['leagues'] = $leagues;
    
        return view('Test', $data);
    }
    
    public function getPlayersByLeagueId($leagueId)
    {
        // Load models
        $mappingModel = new LeaguePlayerMappingModel();

        // Get player data for the selected league
        $data['players'] = $mappingModel->getPlayersByLeagueId($leagueId);

        // Pass player data to the view
        return view('Players_partial', $data);
    }

    // loading player view in test view href player
    public function player()
    {
        $model = new PlayerModel();
        $data['players'] = $model->findAll();
        return view('Player'); // Assuming the view file is named "player.php" and located in the "Views" directory
    }

    // New method to handle player addition
   
}
