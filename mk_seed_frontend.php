<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Seeder Generator</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Add Select2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Laravel Seeder Generator</h2>
        <form action="mk_seed_backend.php" method="POST" id="seederForm">
            <div class="section-1" id="section-1">
                <div class="form-group">
                    <label for="db_name">Database Name:</label>
                    <input type="text" class="form-control" id="db_name" name="db_name" value="twebezli_learn_and_cure_new" required>
                </div>
                <div class="form-group">
                    <label for="db_host">Database Host:</label>
                    <input type="text" class="form-control" id="db_host" name="db_host" value="localhost">
                </div>
                <div class="form-group">
                    <label for="db_user">Database User:</label>
                    <input type="text" class="form-control" id="db_user" name="db_user" value="root">
                </div>
                <div class="form-group">
                    <label for="db_password">Database Password:</label>
                    <input type="password" class="form-control" id="db_password" name="db_password">
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" id="getTablesBtn">Get Tables</button>
                </div>
            </div>
            <div class="section-2" id="tablesContainer" style="display: none;">  
                <div class="form-group">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Checked To Select All Tables </label>
                    </div>
                </div>  
                <div class="form-group" >
                    <label for="tables w-100">Select Tables:</label>
                    <select multiple class="form-control w-100" id="tables" name="tables[]">
                        <!-- Options will be added dynamically using AJAX -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="db_user">Data Limit:</label>
                    <input type="text" class="form-control" id="db_limit" name="db_limit" value="10">
                </div>
                <button type="submit" id="submit" style="display: none;" class="btn btn-primary">Generate Seeders</button>
            </div>
        </form>
    </div>

    <!-- Add Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

    <!-- Add Select2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <!-- Initialize Select2 for the tables select input -->
    <script>
        
        $(document).ready(function () {
            <?php 
                if (isset($_GET['success_message']) && $_GET['success_message']) {
                    echo "Swal.fire({
                        icon: 'success', // You can use 'success', 'error', 'warning', 'info', etc.
                        // title: \"".$_GET['success_message']."\",
                        text: \"".$_GET['success_message']."\",
                        toast: true,
                        position: 'top-end', // You can change the position to 'top-start', 'top-end', 'bottom-start', 'bottom-end', 'top', or 'bottom'
                        showConfirmButton: false,
                        timer: 3000 // Time in milliseconds to auto-close the notification (3 seconds in this case)
                    });";
                }
                if (isset($_GET['error_message']) && $_GET['error_message']) {
                    echo "Swal.fire({
                        icon: 'success', // You can use 'success', 'error', 'warning', 'info', etc.
                        title: ".$_GET['error_message'].",
                        // text: '',
                        toast: true,
                        position: 'top-end', // You can change the position to 'top-start', 'top-end', 'bottom-start', 'bottom-end', 'top', or 'bottom'
                        showConfirmButton: false,
                        timer: 3000 // Time in milliseconds to auto-close the notification (3 seconds in this case)
                    });";
                }
                
            ?>
            function selectAll() {
                $("#tables > option").prop("selected", true);
                $("#tables").trigger("change");
            }

            function deselectAll() {
                $("#tables > option").prop("selected", false);
                $("#tables").trigger("change");
            }
            
            $("#flexSwitchCheckDefault").change(function() {
                // Check the value of the checkbox
                if ($(this).is(":checked")) {
                    selectAll();
                } else {
                    // Checkbox is not checked
                    deselectAll();
                }
            });

            $('#tables').select2({
                placeholder: 'Select tables',
                width: '100%', // Set the width to 100%
            });

            // Event handler for the "Get Tables" button
            $('#getTablesBtn').click(function () {
                // Retrieve database connection details from the form
                var dbName = $('#db_name').val();
                var dbHost = $('#db_host').val();
                var dbUser = $('#db_user').val();
                var dbPassword = $('#db_password').val();

                // AJAX request to fetch tables
                $.ajax({
                    url: 'get_tables.php', // Modify the URL to your PHP script
                    method: 'POST',
                    data: {
                        db_name: dbName,
                        db_host: dbHost,
                        db_user: dbUser,
                        db_password: dbPassword
                    },
                    success: function (response) {
                        // Parse the JSON response
                        var tablesData = response;

                        // Populate the tables select input
                        var select = $('#tables');
                        select.empty();
                        for (var i = 0; i < tablesData.length; i++) {
                            select.append(new Option(tablesData[i], tablesData[i], false, false));
                        }
                        var Toast = Swal.fire({
                            icon: 'success', // You can use 'success', 'error', 'warning', 'info', etc.
                            title: 'Tables retrived successfully',
                            // text: '',
                            toast: true,
                            position: 'top-end', // You can change the position to 'top-start', 'top-end', 'bottom-start', 'bottom-end', 'top', or 'bottom'
                            showConfirmButton: false,
                            timer: 3000 // Time in milliseconds to auto-close the notification (3 seconds in this case)
                        });
                        // [icon: "success",title: "Tables retrived successfully"]
                        // Show the tables select input
                        $('#tablesContainer').show();
                        // Show the submit button
                        $('#submit').show();
                        
                        $('#section-1').hide();
                    },
                    error: function () {
                        alert('Failed to fetch tables. Please check your database connection.');
                    }
                });
            });
        });
    </script>
</body>
</html>
