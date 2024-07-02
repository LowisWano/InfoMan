<?php
// Start output buffering at the beginning of your script
ob_start();
session_start();

require '../php/templates.php';
require '../views/ResidentsViews.php';

html_start('residents.css');

// Sidebar
require '../php/navbar.php';

// Hamburger Sidebar
ResidentsViews::burger_sidebar();

?>

<!-- Residents Contents -->
<div class="container-fluid">

<?php
ResidentsViews::residents_header();
ResidentsViews::add_tenant_modal_view();
ResidentsViews::edit_tenant_modal_view();

// Fetch and display tenants
$tenant_list = ResidentsController::residents_table_data();
ResidentsViews::residents_table_display($tenant_list);

if ($tenant_list) {
    echo '<script>console.log("Tenant list fetched successfully")</script>';
} else {
    echo '<script>console.log("Error fetching tenant list")</script>';
}

// C.U.D Operations
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // Delete Tenant
    if (isset($_POST['delete-tenant-submit'])) {
        // Retrieve the tenant ID to delete
        $tenantIdToDelete = $_GET['tenID'];
        $result = ResidentsController::deleteTenantById($tenantIdToDelete);
    
        if ($result) {
            echo '<script>console.log("Deleted successfully")</script>';
        } else {
            echo '<script>console.log("Error")</script>';
        }
    
        header("Location: /pages/residents.php");
        exit();
    }


    // Create New Tenant with/without Appliances
    if (isset($_POST['create-tenant-submit'])) {
        $newTenant = [
            'tenFname' => $_POST['tenFname'],
            'tenMI' => $_POST['tenMI'],
            'tenLname' => $_POST['tenLname'],
            'tenHouseNum' => $_POST['tenHouseNum'],
            'tenSt' => $_POST['tenSt'],
            'tenBrgy' => $_POST['tenBrgy'],
            'tenCityMun' => $_POST['tenCityMun'],
            'tenProvince' => $_POST['tenProvince'],
            'tenContact' => $_POST['tenContact'],
            'tenBdate' => $_POST['tenBdate'],
            'tenGender' => $_POST['tenGender'],
            'emContactFname' => $_POST['emContactFname'],
            'emContactLname' => $_POST['emContactLname'],
            'emContactMI' => $_POST['emContactMI'],
            'emContactNum' => $_POST['emContactNum']
        ];
    
        $appliances = [];
        foreach($_POST['appliances'] as $appliance){
            $appliances[] = ['appInfo' => $appliance];
        }
    
        $result = ResidentsController::create_new_tenant($newTenant, $appliances);
        if($result){
            echo '<script>console.log("Tenant added successfully")</script>';
        } else {
            echo '<script>console.log("Error adding tenant")</script>';
        }
        header("Location: /pages/residents.php");
        exit();
    }


    // Edit Tenant Submit
    if (isset($_POST['edit-tenant-submit'])) {
        $edit_tenant = array(
            "Edit-tenID" => $_POST['Edit-tenID'],
            "Edit-tenFname" => $_POST['Edit-tenFname'],
            "Edit-tenMI" => $_POST['Edit-tenMI'],
            "Edit-tenLname" => $_POST['Edit-tenLname'],
            "Edit-tenGender" => $_POST['Edit-tenGender'],
            "Edit-tenBdate" => $_POST['Edit-tenBdate'],
            "Edit-tenHouseNum" => $_POST['Edit-tenHouseNum'],
            "Edit-tenSt" => $_POST['Edit-tenSt'],
            "Edit-tenBrgy" => $_POST['Edit-tenBrgy'],
            "Edit-tenCityMun" => $_POST['Edit-tenCityMun'],
            "Edit-tenProvince" => $_POST['Edit-tenProvince'],
            "Edit-tenContact" => $_POST['Edit-tenContact'],
            "Edit-emContactFname" => $_POST['Edit-emContactFname'],
            "Edit-emContactMI" => $_POST['Edit-emContactMI'],
            "Edit-emContactLname" => $_POST['Edit-emContactLname'],
            "Edit-emContactNum" => $_POST['Edit-emContactNum']
        );
    
        $editAppliances = [];
        foreach($_POST['edit-appliances'] as $appliance){
            $editAppliances[] =['appInfo' => $appliance];
        }
        
        $result = ResidentsController::edit_tenant($edit_tenant,$editAppliances);
    
        if ($result) {
            echo '<script>console.log("Tenant edited successfully")</script>';
        } else {
            echo '<script>console.log("Error")</script>';
        }
    
        // Redirect to avoid form resubmission and duplicate entries
        header("Location: /pages/residents.php");
        exit();
    
    }
    
}

echo '<script src="../js/residents_edit&delete_modal.js"></script>';

// End output buffering and flush the buffer
ob_end_flush();
html_end();
?>