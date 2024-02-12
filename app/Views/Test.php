<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
    

    <style>
        .navbar {
            height: 75px;
        }

        .navbar-brand {
            font-size: 35px;
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            font-size: 20px;
            color: white;
        }

        .league-item.selected {
            background-color: #004080;
            color: #ffffff;
        }

        body {
            font-family: "Lato", sans-serif;
            background-color: #e6eff7;
        }

        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #043a6c;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 80px;
        }

        .sidebar a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 22px;
            color: #6aa0d2;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #f1f1f1;
        }

        .sidebar .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: #073763;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
        }

        .openbtn:hover {
            background-color: #3d85c6;
        }

        #main {
            transition: margin-left .5s;
            padding: 10px;
        }
        .submenu {
            display: none;
            position: absolute;
            background-color: #073763;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .submenu ul {
            padding: 0;
        }

        .submenu ul li {
            list-style-type: none;
        }

        .submenu a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        .submenu a:hover {
            color: #f1f1f1;
        }

       
        @media screen and (max-height: 450px) {
            .sidebar {padding-top: 15px;}
            .sidebar a {font-size: 18px;}
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar navbar-dark" style="background-color: #0762b4;" id="Navmenu">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><h3><button class="openbtn" style="margin-top: 12px;">☰ Menu</button></h3></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php foreach ($leagues as $league) : ?>
                    <li class="nav-item">
                        <a class="nav-link league-item" data-league-id="<?= $league['id']; ?>" href="#">
                            <i class="fas fa-trophy"></i> <?= $league['name']; ?>
                        </a>
                        <div class="submenu">
                        <ul>
                            <?php foreach ($league['teams'] as $team) : ?>
                                <li class="team-item" data-teamid="<?= $team['id']; ?>">
                                    <a href="#"><?= $team['name']; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>

<div id="mySidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn">×</a>
    <a href="#" id="loadPlayer"><i class="fa fa-users" aria-hidden="true"></i> Players</a>
    <a href="#" id="loadLeague"><i class="fa fa-trophy" aria-hidden="true"></i> Leagues</a>
</div>

<div id="main">
    <div id="content-container">
        <!-- Content of Partial view will be loaded here -->
        <?= $this->renderSection('content') ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>


<script>
    $(document).ready(function () {
        LoadPlayerGenericGrid();
        // Make an Ajax call when a league menu item is clicked
        $('.team-item').click(function (e) {
            debugger;
            e.preventDefault();
              // Remove the 'selected' class from all items
              $('.team-item').removeClass('selected');
            // Add the 'selected' class to the clicked item
            $(this).addClass('selected');
            var teamid = $(this).data('teamid');

            // Use AJAX to fetch player data for the selected league
            $.ajax({
                url: '<?= base_url('getPlayersByTeamId/'); ?>' + teamid,
                method: 'GET',
                success: function (data) {
                    // Check if the league data is available
                    if (data.trim()) {
                        // Update the content-container with the fetched data
                        $('#content-container').attr("data-teamid",teamid);
                        $('#content-container').html(data);
                        $('.teamFiltercls').hide();
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
        $('.nav-item:first-child .league-item').click();
        // CLICK on SIDE-BAR item PLAYER and load that view
        $("#loadPlayer").on("click", function (e) {
            e.preventDefault();

            // Make an AJAX request to "player" to load "player" view file
            LoadPlayerGenericGrid();
        });
        // Handle change event for team dropdown
        $(document).on('change', '.teamid', function () { 
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
        $(document).on('change', '#teamFilter', function () { 
            LoadPlayerGenericGrid();
        });

        function LoadPlayerGenericGrid()
        {
            var teamid = 0;
            if($('#teamFilter').length > 0)
                teamid = $('#teamFilter').val();
            // Use AJAX to fetch player data for the selected league
            $.ajax({
                url: '<?= base_url('getPlayersByTeamId/'); ?>' + teamid,
                method: 'GET',
                success: function (data) {
                    // Check if the league data is available
                    if (data.trim()) {
                        // Update the content-container with the fetched data
                        $('#content-container').attr("data-teamid",teamid);
                        $('#content-container').html(data);
                        $("#teamFilter").val(teamid);
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
        }

        // CLICK on SIDE-BAR item LEAGUE and load "addleague" view file
        $("#loadLeague").on("click", function (e) {
            e.preventDefault();

            // Make an AJAX request to "addleague" view file.
            $.ajax({
                url: "<?= base_url('addleague'); ?>",
                method: "GET", // or "POST" based on your implementation
                success: function (data) {
                    // Update the content container with the loaded data
                    $("#content-container").html(data);
                },
                error: function (xhr, status, error) {
                    console.error("Error loading content:", error);
                }
            });
        });

        $(".openbtn").on("click", function (e) {
            document.getElementById("mySidebar").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        });
        
        $(".closebtn").on("click", function (e) {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        });

        $('.league-item, .submenu').on({
            mouseenter: function () {
                $(this).closest('.nav-item').find('.submenu').css('display', 'block');
            },
            mouseleave: function () {
                $(this).closest('.nav-item').find('.submenu').css('display', 'none');
            }
        });
    });
</script>
</body>
</html>
