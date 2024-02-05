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
                         ->where('teamid', $teamid)
                         ->join('player', 'player.id = leagueplayermapping.playerid')
                         ->get();

        return $query->getResultArray();
    }

    public function getTeamIdByPlayerId($playerId)
    {
        $query = $this->db->table('leagueplayermapping')
                        ->select('teamid')
                        ->where('playerId', $playerId)
                        ->get();

        $result = $query->getRow();

        return $result ? $result->teamid : null;
    }

    // LeaguePlayerMappingModel
    public function updatePlayerTeam($playerId, $teamId)
    {
        // Update the teamId for the specified playerId
        $data = ['teamid' => $teamId];
        $this->where('playerId', $playerId)->set($data)->update();

        return $this->db->affectedRows() > 0;
    }

}
