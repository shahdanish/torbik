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
    
   
</head>

<body>

    <div class="container mt-5">
     <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3>Player List</h3>
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#AddUser" aria-controls="offcanvasRight">
                <i class="fas fa-user-plus"></i>Add Player
            </button>
           
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
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <!-- Add User Off canves body -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="AddUser" aria-labelledby="offcanvasRightLabel">
      <div class="offcanvas-header">
         <h4 id="offcanvasRightLabel">Add Player</h4>
         <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
   <div class="offcanvas-body">
    <!-- Bootstrap Canvas Body -->
    <div class="container mt-5">
    <div id="alertContainer"></div>
    <form id="addPlayerForm">
        <!-- First Row -->
        <div class="row mb-3">
            <div class="col">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter first name">
            </div>
            <div class="col">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter last name">
            </div>
        </div>

        <!-- Second Row -->
        <div class="row mb-3">
            <div class="col">
                <label for="dateOfBirth" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth">
            </div>
            <div class="col">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
            </div>
        </div>

        <!-- Third Row -->
        <div class="row mb-3">
            <div class="col">
                <label for="image" class="form-label">Choose Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
        </div>

        <div class="mb-3">
            <label for="league_id" class="form-label">Select League</label>
            <!-- Add the form-select class for Bootstrap styling -->
            <select name="league_id" id="league_id" class="form-select">
                <?php foreach ($leagues as $league) : ?>
                    <option value="<?= $league['id']; ?>"><?= $league['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
  </div>
</div>

    <script>
        $(document).ready(function () {
            $('#playerTable').DataTable();
            
            $('#addPlayerForm').submit(function (e) {
            e.preventDefault(); // Prevent the default form submission

            // Serialize form data
            var formData = $(this).serialize();

            // Make an AJAX request to the server
            $.ajax({
                type: 'POST',
                url: '<?= base_url('addPlayerAndMapToLeague'); ?>', // Adjust the URL based on your route
                data: formData,
                success: function (response) {
                    // Display success message or handle the response as needed
                    $('#alertContainer').html(response);
                    setTimeout(function () {
                        $("#AddUser .btn-close").click();
                        $.ajax({
                            url: "<?= base_url('player'); ?>",
                            method: "GET", // or "POST" based on your implementation
                            success: function (data) {
                                // Update the content container with the loaded data
                                $("#content-container").html(data);
                            },
                            error: function (xhr, status, error) {
                                console.error("Error loading content:", error);
                            }
                        });
                    }, 1000); // 1000 milliseconds = 1 second
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error('Error:', error);

                    // Display an error message or take appropriate action
                }
            });
        });
        
        });
    </script>

</body>

</html>
