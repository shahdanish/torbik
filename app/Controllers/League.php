<?php

namespace App\Controllers;

use App\Models\LeagueModel;
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

    public function getPlayersByTeamId($leagueId)
    {
        // Load models
        $mappingModel = new LeaguePlayerMappingModel();

        // Get player data for the selected league
        $data['players'] = $mappingModel->getPlayersByTeamId($leagueId);

        // Pass player data to the view
        return view('Players_partial', $data);
    }
}