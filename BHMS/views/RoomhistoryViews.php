<?php

require_once 'GeneralViews.php';
require_once '../controllers/RoomhistoryController.php';

class RoomhistoryViews extends GeneralViews {

    public static function room_history_header() {
        echo <<<HTML
            <div class="d-flex justify-content-between">
                <div>
                    <span class="page-header">Room History</span><br>
                    <span class="page-sub-header">Browse through the tenant history of each room.</span>
                </div>
                <div class="d-flex align-items-center justify-content-center w-25" >
                    <form method="GET">
                        <div class="btn-group shadow" style="z-index: 1000;">
                            <button class="btn-var-7 dropdown-toggle shadow" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="pe-5 fs-6" style="padding-left: 20px;">Room List</span>
                            </button>
                            <ul class="dropdown-menu" style="background-color: #EDF6F7; z-index:1050;">
        HTML;
                        foreach(RoomhistoryController::all_rooms() as $room) {
                            echo <<<HTML
                                <li class="d-flex justify-content-center">
                                    <input type="submit" name="roomCode" value="{$room['roomID']}" class="dropdown-content">
                                </li>
                            HTML;
                        }
        echo <<<HTML
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        HTML;
    }

    // Edit Occupancy Modal
    public static function editOccupancyModal() {
    
        $rooms = RoomhistoryController::all_rooms();

        echo <<<HTML
            <div class="modal fade" id="editOccupancyModal" tabindex="-1" aria-labelledby="editOccupancyModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered d-flex justify-content-center align-items-center">
            <form method="POST">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-rent-modal">Edit Rent</h5>
                    <button type="button" id="editOccupancyModalCloseBtn" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                
                    <div>
                        <div>
                            <!-- Occupancy ID -->
                            <input type="hidden" name="edit-occupancy-id" id="edit-occupancy-id">
                            <label for="edit-rent-tenant" class="input-label">Tenant Assigned:</label>
                            <!-- Tenant -->
                            <input type="text" id="edit-rent-tenant-name" class="w-100 shadow" disabled>
                            <div class="d-flex justify-content-center input-sub-label">Name</div>
                        </div>
                        <div class="row-fluid">
                            <div class="col-12">
                                <label for="edit-rent-room" class="input-label">Room Details:</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="col-sm-5">
                                    <!-- Room -->
                                    <select name="edit-rent-room" id="edit-rent-room" class="w-100 shadow">
        HTML;
                                        foreach ($rooms as $room){
                                            $room_id = $room['roomID'];
                                            echo<<<HTML
                                                <option value="$room_id">$room_id</option>
                                            HTML;
                                        }       

        echo <<<HTML
                                    </select>
                                    <div class="d-flex justify-content-center input-sub-label">Room Code</div>
                                </div>
                                <div class="col-sm-5">
                                    <!-- Occupancy Type -->
                                    <input type="text" id="edit-rent-type-name" class="w-100 shadow" disabled>
                                    <div class="d-flex justify-content-center input-sub-label">Occupancy Type</div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="col-12">
                                <label for="edit-rent-start" class="input-label">Additional Information:</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="col-sm-5">
                                    <!-- Start Date -->
                                    <input type="date" name="edit-rent-start" id="edit-rent-start" class="w-100 shadow">
                                    <!-- End Date -->
                                    <input type="date" name="edit-rent-end" id="edit-rent-end" class="w-100 shadow" style="display: none">
                                    <div class="d-flex justify-content-center input-sub-label">Starting Date</div>
                                </div>
                                <div class="col-sm-5">
                                    <input type="number" id="edit-rent-rate" class="w-100 shadow" disabled>
                                    <!-- Rent Rate -->
                                    <input type="hidden" name="edit-rent-rate" id="actual-edit-rent-rate">
                                    <div class="d-flex justify-content-center input-sub-label">Monthly Payment</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <!-- Submit Button -->
                    <button type="submit" name="edit-rent-submit" class="btn-var-4">Save</button>
                </div>
                </div>
            </form>
            </div>
        </div>
        HTML;
    }

    public static function deleteOccupancyModal(){
        echo <<<HTML
            <div class="modal fade" id="deleteOccupancyModal" tabindex="-1" aria-labelledby="deleteOccupancyModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                        <p class="confirmation-question">Are you sure you want to delete this occupancy?</p>
                        <form method="POST">
                            <div class="button-container">
                                <input type="hidden" name="delete-occupancy-id" id="delete-occupancy-id">
                                <input type="submit" name="delete-occupancy-submit" id="delete-occupancy-submit" class="btn-delete-yes" value="Yes">
                                <input type="button" name="No" id="Nodelete" class="btn-delete-no" data-bs-dismiss="modal" value="No">
                            </div>
                        </form>
                        <p class="note">Note: Once you have clicked 'Yes', this cannot be undone.</p>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }

}

?>