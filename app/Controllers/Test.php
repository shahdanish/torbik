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
    
    public function getPlayersByTeamId($teamId)
    {
        // Load models
        $mappingModel = new LeaguePlayerMappingModel();
        $teamModel = new TeamModel();
        // Fetch all teams
        $data['teams'] = $teamModel->findAll();
    
        // Output teams for debugging
        
        // Get player data for the selected team
        if ($teamId > 0) {
            $data['players'] = $mappingModel->getPlayersByTeamId($teamId);
        } else {
            $data['players'] = $playerModel->findAll();
        }
    
        foreach ($data['players'] as &$player) {
            $player['teamId'] = $mappingModel->getTeamIdByPlayerId($player['id']);
        }
        
        // Pass player and team data to the partial view
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
