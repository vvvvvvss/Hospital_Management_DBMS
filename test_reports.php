<!-- ========== FILE: test_reports.php ========== -->
<?php
include 'config.php';
if (!isset($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit(); }

$sql = "SELECT t.*, p.Name as PatientName FROM test_report t 
        JOIN patient p ON t.PID = p.PID ORDER BY t.RID DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Test Reports</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Segoe UI'; background: #f5f6fa; }
.navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; display: flex; justify-content: space-between; }
.navbar h1 { font-size: 24px; }
.back-btn { background: rgba(255,255,255,0.2); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; }
.container { max-width: 1400px; margin: 30px auto; padding: 0 20px; }
table { width: 100%; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
th, td { padding: 15px; text-align: left; border-bottom: 1px solid #ddd; }
th { background: #f8f9fa; color: #666; font-weight: 600; }
tr:hover { background: #f8f9fa; }
.test-badge { background: #fff3cd; color: #856404; padding: 5px 12px; border-radius: 15px; font-size: 12px; font-weight: 600; }
</style></head><body>
<div class="navbar"><h1>🔬 Test Reports</h1><a href="dashboard.php" class="back-btn">← Back</a></div>
<div class="container"><h2 style="margin-bottom: 20px;">All Test Reports</h2>
<table><thead><tr><th>Report ID</th><th>Patient Name</th><th>Test Type</th><th>Result</th><th>Test Date</th></tr></thead><tbody>
<?php while($row = $result->fetch_assoc()): ?>
<tr><td><strong>#<?php echo $row['RID']; ?></strong></td><td><?php echo $row['PatientName']; ?></td>
<td><span class="test-badge"><?php echo $row['TestType']; ?></span></td>
<td><?php echo $row['Result']; ?></td>
<td><?php echo date('d-M-Y', strtotime($row['TestDate'])); ?></td></tr>
<?php endwhile; ?>
</tbody></table></div></body></html>

