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
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>image</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($players as $player) : ?>
                            <tr>
                                <td><?= $player['id']; ?></td>
                                <td class="editable" data-field="name"><?= $player['name']; ?><span class="edit-icons"></td>
                                <?php
                                // Assuming $player['Date_of_birth'] is in the format 'Y-m-d'
                                $dateOfBirth = new DateTime($player['Date_of_birth']);
                                $today = new DateTime();
                                $age = $today->diff($dateOfBirth)->y;
                                ?>
                                <td class="editable" data-field="Date_of_birth"><?= $player['Date_of_birth']; ?></td>
                                <td><?= $age; ?> years</td>
                                <td class="editable" data-field="firstname"><?= $player['firstname']; ?><span class="edit-icons"></td>
                                <td class="editable" data-field="lastname"><?= $player['lastname']; ?><span class="edit-icons"></td>
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
        debugger;
         // Get the column index for 'Age'
         var ageColumnIndex = null;

        $('#playerData thead th').each(function (index) {
            if (this.innerText.trim() === 'Age') {
                ageColumnIndex = index;
                return false; // Exit the loop
            }
        });
        // Handle cell click for inline editing
        $('#playerData tbody').on('click', 'td.editable', function (event) {
            debugger;
                if($(".editing").length > 0 && !$(event.target).closest('td.editable').is($(".editing"))) {
                    var that = $(".editing");
                    var cellopened = table.cell(that);
                    cellopened.data(that.find("input").val()).draw();
                    cellopened.node().classList.remove('editing');
                }
                // if($(".editing").length > 0) {
                //     var thatinput = $(".editing").find("input");
                //     thatinput.blur();
                // }
                var cell = table.cell(this);

                if (!cell.node().classList.contains('editing')) {
                    // Entering edit mode
                    cell.node().classList.add('editing');
                    var originalValue = cell.node().innerText;
                    var input = $('<input type="text" class="form-control" value="' + originalValue + '">');

                    setTimeout(function () {
                        input.focus();

                        // Set cursor position to the end of the input value
                        var inputLength = input.val().length;
                        input[0].setSelectionRange(inputLength, inputLength);
                    }, 100);

                    input.blur(function () {
                        debugger;
                        var newValue = input.val();
                        var field = cell.node().getAttribute('data-field');
                        var playerId = table.row(cell.index().row).data()[0];

                        if (field === 'Date_of_birth') {
                            // Update the age column when Date_of_birth is changed
                            var newAge = calculateAge(newValue);
                            var ageCell = table.cell(cell.index().row, ageColumnIndex);
                            ageCell.data(newAge + ' years').draw();
                        }

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

                        // Exit edit mode
                        debugger;
                        cell.node().classList.remove('editing');
                    });

                    // Replace the cell content with the input
                    cell.data('').node().appendChild(input[0]);
                    //input.focus();
                }
            });
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
                    LoadPlayersGrid();
                },
                error: function () {
                    toastr.error('Failed to add player.');
                }
            });
        });
       
    });

    function LoadPlayersGrid() {
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
    }

    // Function to calculate age from date of birth
    function calculateAge(dateOfBirth) {
        var today = new Date();
        var dob = new Date(dateOfBirth);
        var age = today.getFullYear() - dob.getFullYear();

        // Adjust age if birthday hasn't occurred yet this year
        if (today.getMonth() < dob.getMonth() || (today.getMonth() === dob.getMonth() && today.getDate() < dob.getDate())) {
            age--;
        }

        return age;
    }
</script>





</body>