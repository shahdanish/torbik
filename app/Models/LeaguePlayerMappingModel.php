<?php

namespace App\Models;

use CodeIgniter\Model;

class LeaguePlayerMappingModel extends Model
{
    protected $table = 'leagueplayermapping';
    protected $primaryKey = 'id';
    protected $allowedFields = ['playerId', 'leagueId', 'teamid'];

    public function getPlayersByTeamId($teamid)
    {
        // Query to get players for the selected league
        $query = $this->db->table('leagueplayermapping')
                         ->where('leagueId', $teamid)
                         ->join('player', 'player.id = leagueplayermapping.playerid')
                         ->get();

        return $query->getResultArray();
    }
}
