<?php
include '../../connect.php';

$earlier_files = [];

$alert_message = '';

function addAlert($message) {
    global $alert_message;
    $alert_message .= "alert('" . addslashes($message) . "');";
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['pdf_file'])) {
    $upload_dir = 'doc_file/';
    
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $file_name = basename($_FILES['pdf_file']['name']);
    $target_file = $upload_dir . $file_name;
    $uploadOk = 1;

    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($file_type != 'pdf') {
        addAlert('Sorry, only PDF files are allowed.');
        $uploadOk = 0;
    }

    // Check file size (limit to 15MB)
    if ($_FILES['pdf_file']['size'] > 15 * 1024 * 1024) {
        addAlert('Sorry, your file is too large.');
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $target_file)) {
            addAlert("The file " . htmlspecialchars($file_name) . " has been uploaded.");
            
            // Insert file details into the database
            if (isset($_GET['V_ID'])) {
                $v_id = intval($_GET['V_ID']);
                
                $insert_query = "INSERT INTO uploads (V_ID, filename) VALUES (?, ?)";
                $insert_stmt = $objConnect->prepare($insert_query);
                if (!$insert_stmt) {
                    die("Prepare failed: " . $objConnect->error);
                }

                $insert_stmt->bind_param("is", $v_id, $file_name);
                if ($insert_stmt->execute()) {
                    addAlert("Document details have been added to the database.");
                } else {
                    addAlert("Error: Could not add document details to the database.");
                }

                $insert_stmt->close();
            }
        } else {
            addAlert("Sorry, there was an error uploading your file.");
        }
    }

    // Redirect to prevent form resubmission
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

if (isset($_POST['remove_document']) && isset($_POST['file_id'])) {
    $file_id = intval($_POST['file_id']);
    
    // Fetch the filename to delete
    $select_query = "SELECT filename FROM uploads WHERE file_ID = ?";
    $select_stmt = $objConnect->prepare($select_query);
    $select_stmt->bind_param("i", $file_id);
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    
    if ($result->num_rows > 0) {
        $document = $result->fetch_assoc();
        $file_name = $document['filename'];
        $file_path = 'doc_file/' . $file_name;

        // Delete the file from the server
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Delete the record from the database
        $delete_query = "DELETE FROM uploads WHERE file_ID = ?";
        $delete_stmt = $objConnect->prepare($delete_query);
        $delete_stmt->bind_param("i", $file_id);
        if ($delete_stmt->execute()) {
            addAlert("Document has been removed successfully.");
        } else {
            addAlert("Error: Could not remove the document from the database.");
        }
        $delete_stmt->close();
    }
    $select_stmt->close();
}

// Fetch and display document details
$documents = [];
if (isset($_GET['V_ID'])) {
    $v_id = intval($_GET['V_ID']);
    
    $query = "SELECT u.file_ID, u.filename 
              FROM uploads u 
              WHERE u.V_ID = ?";
    
    $stmt = $objConnect->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $objConnect->error);
    }

    $stmt->bind_param("i", $v_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($document = $result->fetch_assoc()) {
        $documents[] = $document;
    }

    $stmt->close();
}

// Fetch earlier files from the "files" table
$earlier_query = "SELECT filename FROM files";
$earlier_result = $objConnect->query($earlier_query);
if ($earlier_result) {
    while ($earlier_file = $earlier_result->fetch_assoc()) {
        $earlier_files[] = $earlier_file['filename'];
    }
}

$objConnect->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document List</title>
    <link href="../../css/dashboard_styles.css" rel="stylesheet">
    <link href="../../css/custom-select.css" rel="stylesheet">
    <link href="../../css/document.css" rel="stylesheet">
    <script src="../../js/logout.js"></script>
</head>
<body>
    <?php include '../../header.php'; ?>
    
    <div class="content">
        <h2>อัพโหลดเอกสาร</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" required>
            <input type="submit" class="btn btn-info" value="Upload PDF">
        </form>
    </div>
    
    <div class="content">
        <h2>เอกสารทั้งหมด</h2>
        <div class="document-list">
            <?php if (!empty($documents)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ไฟล์เอกสาร</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($documents as $document): ?>
                            <tr>
                                <td>
                                    <a href="doc_file/<?php echo htmlspecialchars($document['filename']); ?>" target="_blank">
                                        <?php echo htmlspecialchars($document['filename']); ?>
                                    </a>
                                </td>
                                <td>
                                    <form action="" method="post" style="display:inline;">
                                        <input type="hidden" name="file_id" value="<?php echo htmlspecialchars($document['file_ID']); ?>">
                                        <input type="submit" name="remove_document" class="btn btn-danger" value="Remove Document" onclick="return confirm('Are you sure you want to remove this document?');">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No documents found</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
