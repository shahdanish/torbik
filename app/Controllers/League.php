<?php

namespace App\Controllers;

use App\Models\LeagueModel;
use App\Models\TeamModel;
use App\Models\PlayerModel;
use CodeIgniter\Controller;
use App\Models\LeaguePlayerMappingModel;

class League extends Controller
{
    public function League()
    {
        return "league method";
        $leagueModel = new LeagueModel();
        $data['leagues'] = $leagueModel->findAll();

        return view('League.php', $data);
    }

    public function getPlayersByTeamId($teamId)
    {
        $mappingModel = new LeaguePlayerMappingModel();
        $teamModel = new TeamModel();
        $playerModel =  new PlayerModel();
        // Fetch all teams
        $data['teams'] = $teamModel->findAll();
    
        // Output teams for debugging
        
        // Get player data for the selected team
        if ($teamId > 0) {
            $data['players'] = $mappingModel->getPlayersByTeamId($teamId);
        } else {
            $data['players'] = $playerModel->getActivePlayersByTeamId($teamId);
        }
    
        foreach ($data['players'] as &$player) {
            $player['teamId'] = $mappingModel->getTeamIdByPlayerId($player['id']);
        }
        
        // Pass player and team data to the partial view
        return view('Players_partial', $data);
    }
}