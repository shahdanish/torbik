<?php

namespace App\Models;

use CodeIgniter\Model;

class LeagueModel extends Model
{
    protected $table = 'league';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'name'];
}
