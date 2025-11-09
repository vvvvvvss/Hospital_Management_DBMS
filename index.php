<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if config file exists
if (!file_exists('config.php')) {
    die('<h1>Error: config.php file not found!</h1><p>Please make sure config.php exists in the same folder as index.php</p>');
}

// Include config file
require_once 'config.php';

// Verify connection exists
if (!isset($conn) || $conn === null) {
    die('<h1>Error: Database connection failed!</h1><p>Please check your config.php file and database credentials.</p>');
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $delete_sql = "DELETE FROM patients WHERE id = $id";
    if ($conn->query($delete_sql)) {
        $success = "Patient record deleted successfully!";
    } else {
        $error = "Error deleting record: " . $conn->error;
    }
}

// Handle add/edit form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $age = intval($_POST['age']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $blood_group = $conn->real_escape_string($_POST['blood_group']);
    $medical_history = $conn->real_escape_string($_POST['medical_history']);
    $registration_date = $_POST['registration_date'];
    
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Update existing patient
        $id = intval($_POST['id']);
        $sql = "UPDATE patients SET 
                name='$name', age=$age, gender='$gender', 
                phone='$phone', address='$address', 
                blood_group='$blood_group', medical_history='$medical_history',
                registration_date='$registration_date'
                WHERE id=$id";
        $success = "Patient record updated successfully!";
    } else {
        // Add new patient
        $sql = "INSERT INTO patients (name, age, gender, phone, address, blood_group, medical_history, registration_date) 
                VALUES ('$name', $age, '$gender', '$phone', '$address', '$blood_group', '$medical_history', '$registration_date')";
        $success = "New patient added successfully!";
    }
    
    if (!$conn->query($sql)) {
        $error = "Error: " . $conn->error;
        unset($success);
    }
}

// Get patient for editing
$edit_patient = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $edit_result = $conn->query("SELECT * FROM patients WHERE id = $id");
    $edit_patient = $edit_result->fetch_assoc();
}

// Fetch all patients
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sql = "SELECT * FROM patients";
if (!empty($search)) {
    $sql .= " WHERE name LIKE '%$search%' OR phone LIKE '%$search%'";
}
$sql .= " ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .header {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .header h1 {
            color: #667eea;
            font-size: 32px;
            margin-bottom: 5px;
        }
        
        .header p {
            color: #666;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .search-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .search-box input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        .form-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .form-card h2 {
            color: #333;
            margin-bottom: 20px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        
        .form-group label {
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5568d3;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
            margin-left: 10px;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .btn-small {
            padding: 8px 16px;
            font-size: 14px;
        }
        
        .btn-edit {
            background: #28a745;
            color: white;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        
        .table-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .table-header {
            padding: 20px;
            border-bottom: 2px solid #eee;
        }
        
        .table-header h2 {
            color: #333;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: #f8f9fa;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            color: #666;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
        }
        
        tr:hover {
            background: #f8f9fa;
        }
        
        .blood-badge {
            display: inline-block;
            padding: 5px 12px;
            background: #fee;
            color: #c00;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }
        
        .no-data {
            text-align: center;
            padding: 60px;
            color: #999;
        }
        
        .btn-toggle {
            background: #667eea;
            color: white;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Hospital Management System</h1>
            <p>Patient Records Management - BDMS Mini Project</p>
        </div>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <button class="btn btn-toggle" onclick="toggleForm()">
            <?php echo $edit_patient ? 'Edit Patient' : 'Add New Patient'; ?>
        </button>
        
        <div class="form-card" id="patientForm" style="display: <?php echo $edit_patient ? 'block' : 'none'; ?>;">
            <h2><?php echo $edit_patient ? 'Edit Patient Record' : 'Add New Patient'; ?></h2>
            <form method="POST" action="">
                <?php if ($edit_patient): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_patient['id']; ?>">
                <?php endif; ?>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name *</label>
                        <input type="text" name="name" required 
                               value="<?php echo $edit_patient ? $edit_patient['name'] : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Age *</label>
                        <input type="number" name="age" required min="1" max="150"
                               value="<?php echo $edit_patient ? $edit_patient['age'] : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Gender *</label>
                        <select name="gender" required>
                            <option value="Male" <?php echo ($edit_patient && $edit_patient['gender']=='Male')?'selected':''; ?>>Male</option>
                            <option value="Female" <?php echo ($edit_patient && $edit_patient['gender']=='Female')?'selected':''; ?>>Female</option>
                            <option value="Other" <?php echo ($edit_patient && $edit_patient['gender']=='Other')?'selected':''; ?>>Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Phone *</label>
                        <input type="tel" name="phone" required pattern="[0-9]{10}"
                               value="<?php echo $edit_patient ? $edit_patient['phone'] : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Blood Group *</label>
                        <select name="blood_group" required>
                            <?php 
                            $blood_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                            foreach ($blood_groups as $bg) {
                                $selected = ($edit_patient && $edit_patient['blood_group']==$bg) ? 'selected' : '';
                                echo "<option value='$bg' $selected>$bg</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Registration Date *</label>
                        <input type="date" name="registration_date" required
                               value="<?php echo $edit_patient ? $edit_patient['registration_date'] : date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="form-group full-width">
                        <label>Address *</label>
                        <input type="text" name="address" required
                               value="<?php echo $edit_patient ? $edit_patient['address'] : ''; ?>">
                    </div>
                    
                    <div class="form-group full-width">
                        <label>Medical History</label>
                        <textarea name="medical_history" rows="3"><?php echo $edit_patient ? $edit_patient['medical_history'] : ''; ?></textarea>
                    </div>
                    
                    <div class="form-group full-width">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $edit_patient ? 'Update Patient' : 'Save Patient'; ?>
                        </button>
                        <?php if ($edit_patient): ?>
                            <a href="index.php" class="btn btn-secondary">Cancel</a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="search-box">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search by name or phone number..." 
                       value="<?php echo $search; ?>">
            </form>
        </div>
        
        <div class="table-card">
            <div class="table-header">
                <h2>Patient Records (<?php echo $result->num_rows; ?>)</h2>
            </div>
            
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Age/Gender</th>
                            <th>Phone</th>
                            <th>Blood Group</th>
                            <th>Address</th>
                            <th>Registration Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><strong><?php echo $row['name']; ?></strong></td>
                                <td><?php echo $row['age']; ?> yrs / <?php echo $row['gender']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><span class="blood-badge"><?php echo $row['blood_group']; ?></span></td>
                                <td><?php echo $row['address']; ?></td>
                                <td><?php echo date('d-M-Y', strtotime($row['registration_date'])); ?></td>
                                <td>
                                    <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-small btn-edit">Edit</a>
                                    <a href="?delete=<?php echo $row['id']; ?>" 
                                       onclick="return confirm('Are you sure you want to delete this patient?')" 
                                       class="btn btn-small btn-delete">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-data">
                    <h3>No patients found</h3>
                    <p>Add your first patient to get started</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        function toggleForm() {
            const form = document.getElementById('patientForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>