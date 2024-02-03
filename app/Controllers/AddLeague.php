<?php

namespace App\Controllers;

use App\Models\LeagueModel;
use CodeIgniter\Controller;

class AddLeague extends Controller
{
    public function League()
    {
        $leagueModel = new LeagueModel();
        $data['leagues'] = $leagueModel->findAll();

        return view('AddLeague.php', $data);
    }

    public function addLeague()
    {
        $leagueModel = new LeagueModel();

        $data = [
            'name' => $this->request->getPost('name'),
            // Add other fields as needed
        ];

        // Insert data into the 'league' table
        $leagueModel->insert($data);

        // Check if the request is AJAX
        if ($this->request->isAJAX()) {
            echo '<div class="alert alert-success" role="alert">League added successfully</div>';
        } else {
            return redirect()->to('addleague')->with('success', 'League added successfully');
        }
    }
}
