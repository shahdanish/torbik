<?php

namespace App\Models;

use CodeIgniter\Model;

class PlayerModel extends Model
{
    protected $table      = 'player';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'name', 'Date_of_birth', 'firstname', 'lastname', 'isactive', 'created_at', 'updated_at', 'isdeleted', 'image'];

    // Add any additional configuration or methods if needed
    public function delete($id = null, bool $purge = false)
    {
        // Update the isactive and isdeleted fields
        $data = [
            'isactive' => 0
        ];
    
        // Perform the update
        return $this->update($id, $data);
    }
    

    public function getActivePlayersByTeamId($teamId)
    {
        return $this->where('isactive', 1)
                    ->findAll();
    }
}
