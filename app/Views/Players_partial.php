<!-- ... (head section unchanged) ... -->
<!-- Include toastr.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<!-- Include toastr.js JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<style>
    .fas {
        font-size: 24px;
    }
    .edit-icons {
        margin: 0;margin-top: 7px !important;display: block;text-align: center;
    }
</style>
<body style="background-color: #e6eff7;">

    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Players</h3>
            </div>
            <div class="card-body">
                <table id="playerData" class="table table-hover">
                    <thead>
                        <tr class="table-active">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date of Birth</th>
                            <th>Age</th>
                            <th>FirstName</th>
                            <th>LastName</th>
                            <th>image</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($players as $player) : ?>
                            <tr>
                                <td><?= $player['id']; ?></td>
                                <td class="editable" data-field="name"><?= $player['name']; ?><span class="edit-icons"><i class="fas fa-check text-success save-icon"></i><i class="fas fa-times text-danger cancel-icon"></i></span></td>
                                <?php
                                // Assuming $player['Date_of_birth'] is in the format 'Y-m-d'
                                $dateOfBirth = new DateTime($player['Date_of_birth']);
                                $today = new DateTime();
                                $age = $today->diff($dateOfBirth)->y;
                                ?>
                                <td class="editable" data-field="Date_of_birth"><?= $player['Date_of_birth']; ?><span class="edit-icons"><i class="fas fa-check text-success save-icon"></i><i class="fas fa-times text-danger cancel-icon"></i></span></td>
                                <td><?= $age; ?> years</td>
                                <td class="editable" data-field="firstname"><?= $player['firstname']; ?><span class="edit-icons"><i class="fas fa-check text-success save-icon"></i><i class="fas fa-times text-danger cancel-icon"></i></span></td>
                                <td class="editable" data-field="lastname"><?= $player['lastname']; ?><span class="edit-icons"><i class="fas fa-check text-success save-icon"></i><i class="fas fa-times text-danger cancel-icon"></i></span></td>
                                <td class="editable" data-field="image">
                                    <img style="max-width:100px;" src="data:image/png;base64,<?= $player['image']; ?>" alt="Base64 Image"> 
                                <td>
                                    <!-- Delete icon with a link to the delete action -->
                                    <a href="<?= base_url('delete/' . $player['id']); ?>" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
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
        var table = $('#playerData').DataTable({
            "paging": false,
            "ordering": false // Disable sorting
        });
        

        // Handle cell click for inline editing
        $('#playerData tbody').on('click', 'td.editable', function () {
            var cell = table.cell(this);

            if (!cell.node().classList.contains('editing')) {
                // Entering edit mode
                cell.node().classList.add('editing');
                var originalValue = cell.node().innerText;
                var input = $('<input type="text" class="form-control"  value="' + originalValue + '">');
                var icons = $('<span class="edit-icons"><i class="fas fa-check text-success"></i>&nbsp;<i class="fas fa-times text-danger"></i></span>');


                input.focus();

                var blurTimeout;
                input.blur(function () {
                    // Do nothing if already clicked on tick or cross icons
                    if (!icons.find('.fa-check, .fa-times').is(':focus')) {
                        clearTimeout(blurTimeout); // Clear the previous timeout
                        blurTimeout = setTimeout(function () {
                            cell.data(originalValue).draw();
                            cell.node().classList.remove('editing');
                            icons.remove();
                        }, 100); // Adjust the delay as needed
                    }
                });

                icons.find('.fa-check').click(function () {
                    debugger;
                    // Save changes
                    var newValue = input.val();
                    var field = cell.node().getAttribute('data-field');
                    var playerId = table.row(cell.index().row).data()[0];
                    $.ajax({
                        url: '<?= base_url('updatePlayerData'); ?>',
                        method: 'POST',
                        data: {
                            id: playerId,
                            field: field,
                            value: newValue
                        },
                        success: function (response) {
                            if (response.success) {
                                // Update the cell with the new value
                                cell.data(newValue).draw();
                            } else {
                                console.error(response.message);
                            }
                        },
                        error: function () {
                            console.error('Failed to update player data.');
                        }
                    });
                    // Add your logic here to save the changes to the database
                    // For example, you can make an AJAX call to update the database
                    // After saving, update the cell with the new value
                    cell.data(newValue).draw();
                    cell.node().classList.remove('editing');
                    icons.remove();
                });

                icons.find('.fa-times').click(function () {
                    // Cancel changes
                    cell.data(originalValue).draw();
                    cell.node().classList.remove('editing');
                    icons.remove();
                });
                
                // Replace the cell content with the input and icons
                cell.data('').node().appendChild(input[0]);
                cell.node().appendChild(icons[0]);

            }
        });
        $('.edit-icons').remove();
         // Add an empty row with input fields (except for the image) at the end of the table
        var emptyRow = [
            '', // ID
            '<input type="text" class="form-control" data-field="name" value="">', // Name
            '<input type="text" class="form-control" data-field="Date_of_birth" value="">', // Date of Birth
            '', // Age (will be calculated later)
            '<input type="text" class="form-control" data-field="firstname" value="">', // FirstName
            '<input type="text" class="form-control" data-field="lastname" value="">', // LastName
            '<div class="input-group">' +
                '<div class="input-group-append">' +
                    '<input type="file" id="imageInput" name="imageInput"  accept="image/*" style="display:none">' +
                    '<button class="btn btn-outline-secondary upload-image-btn" type="button">Upload</button>' +
                '</div>' +
            '</div>', // Image
            '<button class="btn btn-success save-new-player">Save</button>' // Save button
        ];

        table.row.add(emptyRow).draw(false); 

         // Event listener for image upload button
        // Trigger file input click when the "Upload" button is clicked
        $('#playerData tbody').on('click', '.upload-image-btn', function () {
            $('#imageInput').click();
        });

        // Handle file input change event
        $('#imageInput').on('change', function () {
            // Read the selected image file
            var fileInput = this;
            var file = fileInput.files[0];

            if (file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    // Display the selected image on the button or preview area if needed
                    // For now, we'll just log the base64-encoded image data
                    console.log(e.target.result);
                };

                reader.readAsDataURL(file);
            }
        });
         // Handle the click event for the Save button in the new row
         $('#playerData tbody').on('click', '.save-new-player', function () {
            var newRow = $(this).closest('tr');
            var playerId = newRow.find('td:eq(0)').text(); // Assuming ID is in the first column

            // Collect data from the input fields
            var name = newRow.find('td:eq(1) input').val();
            var dateOfBirth = newRow.find('td:eq(2) input').val();
            var firstname = newRow.find('td:eq(4) input').val();
            var lastname = newRow.find('td:eq(5) input').val();

            // Use FormData to handle file uploads
            var formData = new FormData();
            formData.append('name', name);
            formData.append('dateOfBirth', dateOfBirth);
            formData.append('firstname', firstname);
            formData.append('lastname', lastname);
            formData.append('teamid', $('#content-container').data('teamid'));

            // Get the selected image file
            var imageInput = newRow.find('#imageInput')[0];
            formData.append('image', imageInput.files[0]);

            // Make the AJAX request
            $.ajax({
                url: '<?= base_url('addPlayerAndMapToLeague'); ?>',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    toastr.success("Player Saved Successfully!");
                    var teamid = $('#content-container').data('teamid');
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
                },
                error: function () {
                    toastr.error('Failed to add player.');
                }
            });
        });
       
    });
</script>





</body>