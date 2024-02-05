<!-- app/Views/players/index.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player List</title>

    <!-- Include jQuery and DataTables CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script  src="https://code.jquery.com/jquery-3.7.1.min.js"  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="  crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <!-- Include toastr.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    
   
</head>

<body>

    <div class="container mt-5">
     <div class="card">
        <!-- <div class="card-header d-flex justify-content-between">
            <h3>Player List</h3>
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#AddUser" aria-controls="offcanvasRight">
                <i class="fas fa-user-plus"></i>Add Player
            </button>
           
        </div> -->
        <div class="card-body">
            <table id="playerTable" class="table table-hover">
                <thead>
                    <tr class="table-secondary">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>FirstName</th>
                        <th>LastName</th>
                        <th>Image</th>
                        <th>Select Team</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($players as $player) : ?>
                        <tr>
                            <td><?= $player['id']; ?></td>
                            <td><?= $player['name']; ?></td>
                            <td><?= $player['firstname']; ?></td>
                            <td><?= $player['lastname']; ?></td>
                            <td><?= $player['Date_of_birth']; ?></td>
                            <td class="player-image"><img src="data:image/jpeg;base64,<?= $player['image']; ?>" alt="Player Image" width="50" ></td>
                            <td> 
                                <select name="teamid" id="teamid" class="form-select chosen-select" data-playerid="<?= $player['id']; ?>">
                                    <?php foreach ($teams as $team) : ?>
                                        <option value="<?= $team['id']; ?>" <?= ($player['teamId'] == $team['id']) ? 'selected' : ''; ?>>
                                            <?= $team['name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>

    <script>
        $(document).ready(function () {
            $('#playerTable').DataTable();
            $(".chosen-select").chosen();
             // Handle change event for team dropdown
            $('#teamid').on('change', function () {
                debugger;
                var playerId = $(this).data('playerid');
                var selectedTeamId = $(this).val();

                // Make an AJAX call to update the player's team
                $.ajax({
                    url: '<?= base_url('updatePlayerTeam'); ?>',
                    method: 'POST',
                    data: {
                        playerId: playerId,
                        teamId: selectedTeamId
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success("Team updated successfully!");
                        } else {
                            toastr.error("Failed to update team.");
                        }
                    },
                    error: function () {
                        toastr.error("Failed to update team. Please try again.");
                    }
                });
            });   
                
        });
    </script>

</body>

</html>
