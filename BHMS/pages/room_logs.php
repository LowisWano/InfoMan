<?php

ob_start();

require '../php/templates.php';
require '../views/RoomlogsViews.php';

html_start('room_logs.css');

// Sidebar
require '../php/navbar.php';

// Burger Sidebar
RoomlogsViews::burger_sidebar();

?> 

<!-- Room Logs Section -->
<div class="container-fluid">

    <!-- Header -->
    <?php RoomlogsViews::room_logs_header() ?>

    <!-- Room Log Actions -->
    <div class="rm-log-button">
        <button class="show-avail-rm-btn">Show Available Rooms</button>
        <button type="button" data-bs-toggle="modal" data-bs-target="#add-new-rm">Add New Room</button>
    </div>

    <!-- Room Information -->
    <div class="row rm-container">

    <?php
        // Code for displaying all the Room Cards
        RoomlogsViews::room_info_cards();
    ?>
        
</div> 

<!-- Room Logs Modals -->
<?php 
RoomlogsViews::room_info_modal(); 
RoomlogsViews::deleteOccupancyModal();
RoomlogsViews::editOccupancyModal();

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Editing Occupancy
    if(isset($_POST['edit-rent-submit'])){
        $editInfo = array(
            'occupancyID' => $_POST['edit-occupancy-id'],
            'roomID' => $_POST['edit-rent-room'],
            'occDateStart' => $_POST['edit-rent-start'],
            'occDateEnd' => $_POST['edit-rent-end'],
        );

        $result = RoomlogsController::editOccupancy($editInfo);
        if($result){
            // Redirect to the same page or to a confirmation page after successful edit
            header('Location: room_logs.php?editOccStatus=success');
            exit();
        } else {
            // Handle the error case, potentially redirecting with an error flag or displaying an error message
            header('Location: room_logs.php?editOccStatus=error');
            exit();
        }
    }
    
    // Deleting Occupancy
    if (isset($_POST['delete-occupancy-id'])) {

        $delOccInfo = $_POST['delete-occupancy-id'];
        // Console log the delete occupancy id
        echo "<script>console.log('Delete Occ ID: $delOccInfo');</script>";

        $result = RoomlogsController::delete_occupancy($delOccInfo);
        if ($result) {
            // Redirect to the same page or to a confirmation page after successful deletion
            header('Location: room_logs.php?deleteOccStatus=success');
            exit();
        } else {
            // Handle the error case, potentially redirecting with an error flag or displaying an error message
            header('Location: room_logs.php?deleteOccStatus=error');
            exit();
        }
    }

}
?>

<!-- Add New Room Modal -->
<div class="modal fade" id="add-new-rm" tabindex="-1" aria-labelledby="add-new-rm-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content m-5">
        <div class="modal-header">
            <h3 class="rm-modal-title" id="add-new-rm-modal">Add New Room</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post">
            <div class="modal-body">
                <div class="row-fluid d-flex justify-content-between">
                    <div class="d-flex flex-column justify-content-evenly w-50">
                        <label for="add-new-rm-code" class="input-label my-3">Room Code: </label>
                        <label for="add-new-rm-cap" class="input-label my-3">Room Capacity: </label>
                    </div>
                    <div class="d-flex flex-column justify-content-evenly w-50">
                        <input type="text" name="add-new-rm-code" id="add-new-rm-code" placeholder="Enter room code..." class="my-3 shadow w-100"><br>
                        <input type="number" name="add-new-rm-cap" id="add-new-rm-cap" placeholder="Enter room capacity..." class="my-3 shadow w-100">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn-var-4">Add</button>
            </div>
        </form>
    </div>
    </div>
</div>

<script src="../js/roomLogsGeneral.js"></script>

<?php 

ob_end_flush();
html_end(); 
?>
