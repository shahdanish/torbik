<!-- app/Views/players_partial.php -->

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
    
   
</head>

<body style="background-color: #e6eff7;">


    <div class="container mt-5">
     <div class="card ">
         <div class="card-header d-flex justify-content-between ">
            <h3>Players</h3>
            
         </div>
        <div class="card-body">
            <table id="playerData" class="table table-hover">
                <thead >
                    <tr class="table-active">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Age</th>
                        <th>FirstName</th>
                        <th>LastName</th>
                        <!-- <th>Image</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($players as $player) : ?>
                        <tr>
                            <td><?= $player['id']; ?></td>
                            <td><?= $player['name']; ?></td>
                            <?php
                            // Assuming $player['Date_of_birth'] is in the format 'Y-m-d'
                                $dateOfBirth = new DateTime($player['Date_of_birth']);
                                $today = new DateTime();
                                $age = $today->diff($dateOfBirth)->y;
                            ?>
                            <td><?= $player['Date_of_birth']; ?></td>
                            <td><?= $age; ?> years</td>
                            <td><?= $player['firstname']; ?></td>
                            <td><?= $player['lastname']; ?></td>
                           
                            <!-- <td class="player-image"><img src="data:image/jpeg;base64,<?= $player['image']; ?>" alt="Player Image" width="50" ></td> -->
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
            $('#playerData').DataTable();
        });
    </script>

</body>

</html>
