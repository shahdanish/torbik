<!-- app/Views/league_view.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>League Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script  src="https://code.jquery.com/jquery-3.7.1.min.js"  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="  crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <!-- CSS -->
    <style>
    .navbar {
        height: 80px; /* Set the desired height */
    }

    .navbar-brand {
        font-size: 35px; /* Set the desired font size */
        font-weight: bold; /* Optionally, set font weight */
    }

    .navbar-nav .nav-link {
        font-size: 20px; /* Set the desired font size */
    }
</style>

</head>
<body style="background-color: #e6eff7;">

<nav class="navbar navbar-expand-lg navbar navbar-dark" style="background-color: #0762b4;" id="Navmenu">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><h3><b>Football</b></h3></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
               
                <?php foreach ($leagues as $league) : ?>
                    <li class="nav-item">
                    <a class="nav-link league-item" data-league-id="<?= $league['id']; ?>" href="#">
                                <?= $league['name']; ?>
                      </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>

<div id="content-container">
            <!-- Content will be loaded here -->
            <?= $this->renderSection('content') ?>
</div>
    
<div id ="Player">

</div>

</body>
<!-- Make sure to include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        // Making method for load Player Data
        function loadPlayerData() {
        // Make an Ajax call to the Player action
        $.ajax({
            url: '<?= base_url('player') ?>',
            type: 'GET',
            success: function (data) {
                // Update the content in the container
                $('#content-container').html(data);
            },
            error: function () {
                // Handle errors if needed
                console.error('Error in Ajax call');
            }
        });
        }

        loadPlayerData();  //Calling method to load Player Data

        $('.navbar-brand').click(function (e) {
        e.preventDefault();
        loadPlayerData(); // Load player data when the Football navbar brand is clicked
        
        
      }); 
    
       // Make an Ajax call when a league menu item is clicked
         $('.league-item').click(function (e) {
        e.preventDefault();
        var leagueId = $(this).data('league-id');

        // Use AJAX to fetch player data for the selected league
        $.ajax({
            url: '<?= base_url('league/getPlayersByLeagueId/'); ?>' + leagueId,
            method: 'GET',
            success: function (data) {
                // Check if the league data is available
                if (data.trim()) {
                    // Update the content-container with the fetched data
                    $('#content-container').html(data);
                } else {
                    // If no league data is available, hide the container
                    $('#content-container').html('');
                }
            },
            error: function () {
                // Handle errors if any
                console.log('Error fetching player data.');
            }
        });
    });
    });

    
</script>
</html>
