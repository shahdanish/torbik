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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" integrity="sha512-WOJJesT7Bzueb2N2vuVKpHqg1u3TM4Z9sPT6Ll5ubJNerqO64yN1s/tU8iV2yQrB9ACaL3fJMSl3KjPpb7UG1A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" integrity="sha512-xO5W8lrRRNpQrA7mwD4FyffONcUWmGNWtwmrWGtUUbOIlbQ9XgCV9GQbEiVX8AubvGR/ooN4jv2YgihKKzEzvQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <!-- Add a select dropdown for team filtering -->
                <select id="teamFilter" class="form-select chosen-select">
                    <option value="">Filter by Team</option>
                    <option value="0">All Teams</option>
                    <?php foreach ($teams as $team) : ?>
                        <option value="<?= $team['id']; ?>"><?= $team['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
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
                                    <select name="teamid" class="form-select chosen-select teamid" data-playerid="<?= $player['id']; ?>">
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

    <script>
        $(document).ready(function () {
            var playertable = $('#playerTable').DataTable({
                "pageLength": 50, // Set the default number of records per page to 50
            });

            // Handle change event for team dropdown
            $('.teamid').on('change', function () {
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

            // Handle change event for team filter dropdown
            // Handle change event for team filter dropdown
        // $('#teamFilter').on('change', function () {
        //     var selectedTeamId = $(this).val();

        //     // Filter DataTable based on selected team
        //     playertable.column(6).search(selectedTeamId ? '^' + selectedTeamId + '$' : '', true, false).draw();
        // });

        });
    </script>

</body>

</html>
