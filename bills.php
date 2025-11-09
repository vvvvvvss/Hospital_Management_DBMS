<?php
include 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Fetch bills with patient names
$sql = "SELECT b.*, p.Name as PatientName FROM bills b 
        JOIN patient p ON b.PID = p.PID 
        ORDER BY b.BID DESC";
$result = $conn->query($sql);

// Get patients for dropdown
$patients = $conn->query("SELECT PID, Name FROM patient ORDER BY Name");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bills - Hospital Management</title>
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
        
        .status-paid {
            background: #d4edda;
            color: #155724;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .amount {
            font-weight: bold;
            color: #28a745;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>💰 Bills & Payments</h1>
        <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>
    
    <div class="container">
        <h2 style="margin-bottom: 20px;">All Bills</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Bill ID</th>
                    <th>Patient Name</th>
                    <th>Amount</th>
                    <th>Bill Date</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><strong>#<?php echo $row['BID']; ?></strong></td>
                        <td><?php echo $row['PatientName']; ?></td>
                        <td class="amount">₹<?php echo number_format($row['Amount'], 2); ?></td>
                        <td><?php echo date('d-M-Y', strtotime($row['BillDate'])); ?></td>
                        <td>
                            <span class="status-<?php echo strtolower($row['PaymentStatus']); ?>">
                                <?php echo $row['PaymentStatus']; ?>
                            </span>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>