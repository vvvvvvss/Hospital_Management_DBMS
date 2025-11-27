<?php
include 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Fetch doctors with employee details
$sql = "SELECT d.*, e.Name, e.Age, e.Gender, e.MobNo, e.Address, e.Salary 
        FROM doctor d 
        JOIN employee e ON d.DoctorID = e.EID 
        ORDER BY d.DoctorID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors - Hospital Management</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f6fa;
        }
        
        .navbar {
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
             */
            background: #3fef3cff;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar h1 { font-size: 24px; }
        
        .back-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        
        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
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
        
        .dept-badge {
            background: #e7f3ff;
            color: #2196F3;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Doctor Management - Vikram Hospital</h1>
        <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>
    
    <div class="container">
        <h2 style="margin-bottom: 20px;">All Doctors</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Doctor ID</th>
                    <th>Name</th>
                    <th>Age/Gender</th>
                    <th>Department</th>
                    <th>Qualification</th>
                    <th>Mobile</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><strong>#<?php echo $row['DoctorID']; ?></strong></td>
                        <td><?php echo $row['Name']; ?></td>
                        <td><?php echo $row['Age']; ?> yrs / <?php echo $row['Gender']; ?></td>
                        <td><span class="dept-badge"><?php echo $row['Department']; ?></span></td>
                        <td><?php echo $row['Qualification']; ?></td>
                        <td><?php echo $row['MobNo']; ?></td>
                        <td>₹<?php echo number_format($row['Salary'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>