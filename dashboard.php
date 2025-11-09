<?php
include 'config.php';

// Check if logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Get statistics
$total_patients = $conn->query("SELECT COUNT(*) as count FROM patient")->fetch_assoc()['count'];
$total_doctors = $conn->query("SELECT COUNT(*) as count FROM doctor")->fetch_assoc()['count'];
$total_nurses = $conn->query("SELECT COUNT(*) as count FROM nurse")->fetch_assoc()['count'];
$total_bills = $conn->query("SELECT COUNT(*) as count FROM bills")->fetch_assoc()['count'];
$pending_bills = $conn->query("SELECT COUNT(*) as count FROM bills WHERE PaymentStatus='Pending'")->fetch_assoc()['count'];
$total_revenue = $conn->query("SELECT SUM(Amount) as total FROM bills WHERE PaymentStatus='Paid'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Hospital Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
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
        
        .navbar h1 {
            font-size: 24px;
        }
        
        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .logout-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .stat-card .icon {
            font-size: 40px;
            margin-bottom: 15px;
        }
        
        .stat-card h3 {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        
        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
            color: #333;
        }
        
        .stat-card.patients { border-left: 4px solid #3498db; }
        .stat-card.doctors { border-left: 4px solid #2ecc71; }
        .stat-card.nurses { border-left: 4px solid #e74c3c; }
        .stat-card.bills { border-left: 4px solid #f39c12; }
        .stat-card.revenue { border-left: 4px solid #9b59b6; }
        
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }
        
        .menu-card {
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            text-align: center;
            text-decoration: none;
            color: #333;
            transition: all 0.3s;
        }
        
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .menu-card .icon {
            font-size: 60px;
            margin-bottom: 20px;
        }
        
        .menu-card h3 {
            font-size: 22px;
            margin-bottom: 10px;
        }
        
        .menu-card p {
            color: #666;
            font-size: 14px;
        }
        
        .section-title {
            font-size: 24px;
            color: #333;
            margin: 40px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>🏥 Hospital Management System</h1>
        <div class="user-info">
            <span>Welcome, <?php echo $_SESSION['username']; ?></span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <h2 class="section-title">📊 Dashboard Statistics</h2>
        
        <div class="stats-grid">
            <div class="stat-card patients">
                <div class="icon">👨‍⚕️</div>
                <h3>Total Patients</h3>
                <div class="number"><?php echo $total_patients; ?></div>
            </div>
            
            <div class="stat-card doctors">
                <div class="icon">🩺</div>
                <h3>Total Doctors</h3>
                <div class="number"><?php echo $total_doctors; ?></div>
            </div>
            
            <div class="stat-card nurses">
                <div class="icon">👩‍⚕️</div>
                <h3>Total Nurses</h3>
                <div class="number"><?php echo $total_nurses; ?></div>
            </div>
            
            <div class="stat-card bills">
                <div class="icon">💰</div>
                <h3>Pending Bills</h3>
                <div class="number"><?php echo $pending_bills; ?></div>
            </div>
            
            <div class="stat-card revenue">
                <div class="icon">💵</div>
                <h3>Total Revenue</h3>
                <div class="number">₹<?php echo number_format($total_revenue, 2); ?></div>
            </div>
        </div>
        
        <h2 class="section-title">📋 Management Modules</h2>
        
        <div class="menu-grid">
            <a href="patients.php" class="menu-card">
                <div class="icon">👨‍⚕️</div>
                <h3>Patients</h3>
                <p>Manage patient records and information</p>
            </a>
            
            <a href="doctors.php" class="menu-card">
                <div class="icon">🩺</div>
                <h3>Doctors</h3>
                <p>View and manage doctor details</p>
            </a>
            
            <a href="nurses.php" class="menu-card">
                <div class="icon">👩‍⚕️</div>
                <h3>Nurses</h3>
                <p>Manage nursing staff information</p>
            </a>
            
            <a href="consultations.php" class="menu-card">
                <div class="icon">📋</div>
                <h3>Consultations</h3>
                <p>Patient-Doctor consultation records</p>
            </a>
            
            <a href="test_reports.php" class="menu-card">
                <div class="icon">🔬</div>
                <h3>Test Reports</h3>
                <p>Medical test reports and results</p>
            </a>
            
            <a href="bills.php" class="menu-card">
                <div class="icon">💰</div>
                <h3>Bills & Payments</h3>
                <p>Billing and payment management</p>
            </a>
        </div>
    </div>
</body>
</html>