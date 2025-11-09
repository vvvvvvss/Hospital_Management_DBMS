<?php
include 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $age = intval($_POST['age']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $dob = $_POST['dob'];
    $mobno = $conn->real_escape_string($_POST['mobno']);
    
    if (isset($_POST['pid']) && !empty($_POST['pid'])) {
        $pid = intval($_POST['pid']);
        $sql = "UPDATE patient SET Name='$name', Age=$age, Gender='$gender', DOB='$dob', MobNo='$mobno' WHERE PID=$pid";
        $success = "Patient updated successfully!";
    } else {
        $sql = "INSERT INTO patient (Name, Age, Gender, DOB, MobNo) VALUES ('$name', $age, '$gender', '$dob', '$mobno')";
        $success = "Patient added successfully!";
    }
    
    $conn->query($sql);
}

// Handle Delete
if (isset($_GET['delete'])) {
    $pid = intval($_GET['delete']);
    $conn->query("DELETE FROM patient WHERE PID = $pid");
    $success = "Patient deleted successfully!";
}

// Get patient for editing
$edit_patient = null;
if (isset($_GET['edit'])) {
    $pid = intval($_GET['edit']);
    $edit_result = $conn->query("SELECT * FROM patient WHERE PID = $pid");
    $edit_patient = $edit_result->fetch_assoc();
}

// Fetch all patients
$result = $conn->query("SELECT * FROM patient ORDER BY PID DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients - Hospital Management</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f6fa;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar h1 { font-size: 24px; }
        
        .back-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .back-btn:hover { background: rgba(255,255,255,0.3); }
        
        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .btn-add {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        
        .form-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }
        
        table {
            width: 100%;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background: #f8f9fa;
            color: #666;
            font-weight: 600;
        }
        
        tr:hover { background: #f8f9fa; }
        
        .btn-small {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            margin-right: 5px;
        }
        
        .btn-edit {
            background: #28a745;
            color: white;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>👨‍⚕️ Patient Management</h1>
        <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>
    
    <div class="container">
        <?php if (isset($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <button class="btn-add" onclick="toggleForm()">
            <?php echo $edit_patient ? '✏️ Edit Patient' : '➕ Add New Patient'; ?>
        </button>
        
        <div class="form-card" id="patientForm" style="display: <?php echo $edit_patient ? 'block' : 'none'; ?>;">
            <h2><?php echo $edit_patient ? 'Edit Patient' : 'Add New Patient'; ?></h2>
            <form method="POST" action="">
                <?php if ($edit_patient): ?>
                    <input type="hidden" name="pid" value="<?php echo $edit_patient['PID']; ?>">
                <?php endif; ?>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" name="name" required value="<?php echo $edit_patient ? $edit_patient['Name'] : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Age *</label>
                        <input type="number" name="age" required value="<?php echo $edit_patient ? $edit_patient['Age'] : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Gender *</label>
                        <select name="gender" required>
                            <option value="Male" <?php echo ($edit_patient && $edit_patient['Gender']=='Male')?'selected':''; ?>>Male</option>
                            <option value="Female" <?php echo ($edit_patient && $edit_patient['Gender']=='Female')?'selected':''; ?>>Female</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Date of Birth *</label>
                        <input type="date" name="dob" required value="<?php echo $edit_patient ? $edit_patient['DOB'] : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Mobile Number *</label>
                        <input type="tel" name="mobno" required value="<?php echo $edit_patient ? $edit_patient['MobNo'] : ''; ?>">
                    </div>
                </div>
                
                <button type="submit" class="btn-primary">
                    <?php echo $edit_patient ? '💾 Update' : '💾 Save'; ?>
                </button>
                <?php if ($edit_patient): ?>
                    <a href="patients.php" class="btn-secondary">Cancel</a>
                <?php endif; ?>
            </form>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>Mobile</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['PID']; ?></td>
                        <td><strong><?php echo $row['Name']; ?></strong></td>
                        <td><?php echo $row['Age']; ?> years</td>
                        <td><?php echo $row['Gender']; ?></td>
                        <td><?php echo date('d-M-Y', strtotime($row['DOB'])); ?></td>
                        <td><?php echo $row['MobNo']; ?></td>
                        <td>
                            <a href="?edit=<?php echo $row['PID']; ?>" class="btn-small btn-edit">Edit</a>
                            <a href="?delete=<?php echo $row['PID']; ?>" class="btn-small btn-delete" onclick="return confirm('Delete this patient?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
    <script>
        function toggleForm() {
            const form = document.getElementById('patientForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>