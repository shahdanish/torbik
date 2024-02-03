<!-- app/Views/players/index.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>League List</title>

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
            <h3>League List</h3>
            <button class="btn btn-primary " type="button" data-bs-toggle="offcanvas" data-bs-target="#AddUser" aria-controls="offcanvasRight">
              <i class="fas fa-trophy"></i> Add League
            </button>
           
        </div>
        <div class="card-body">
            <table id="Addleague" class="table table-hover">
                <thead >
                    <tr class="table-active">
                        <th>ID</th>
                        <th>Name</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leagues as $league): ?>
                    <tr>
                        <td><?= $league['id']; ?></td>
                        <td><?= $league['name']; ?></td>
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
         <h4 id="offcanvasRightLabel">Add League</h4>
         <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
   <div class="offcanvas-body">
    <!-- Bootstrap Canvas Body -->
<div class="container-fluid ">
    <div id="alertContainer"></div> <!-- Container for displaying success/error messages -->
    <form id="addLeagueForm">
        <!-- First Row -->
        <div class="row mb-4">
            <div class="col">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
            
            </div>
        </div>
         <!-- Submit Button -->
        <button type="button" class="btn btn-primary" onclick="addLeague()">Submit</button>
    </form>
</div>

  </div>
</div>

    <script>
        $(document).ready(function () {
            $('#Addleague').DataTable();
        });
            // To Add League
        function addLeague() {
            // Serialize form data
            var formData = $('#addLeagueForm').serialize();

            $.ajax({
                type: 'POST',
                url: '<?= base_url('addleaguedata'); ?>',
                data: formData,
                success: function(response) {

                    // Display success or error message
                    $('#alertContainer').html(response);
                    setTimeout(function () {
                        $("#AddUser .btn-close").click();
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
                    }, 1000); // 1000 milliseconds = 1 second
                   
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#alertContainer').html('<div class="alert alert-danger" role="alert">An error occurred. Please try again later.</div>');
                }
            });
        }
    </script>

</body>

</html>
