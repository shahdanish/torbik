<?php

namespace App\Models;

use CodeIgniter\Model;

class PlayerModel extends Model
{
    protected $table      = 'player';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'name', 'Date_of_birth', 'firstname', 'lastname', 'isactive', 'created_at', 'updated_at', 'isdeleted', 'image'];

    // Add any additional configuration or methods if needed
    
   
}
