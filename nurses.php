<!-- ========== FILE: nurses.php ========== -->
<?php
include 'config.php';
if (!isset($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit(); }

$sql = "SELECT n.*, e.Name, e.Age, e.Gender, e.MobNo, e.Address, e.Salary 
        FROM nurse n JOIN employee e ON n.NurseID = e.EID ORDER BY n.NurseID";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Nurses</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Segoe UI'; background: #f5f6fa; }
.navbar { 
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);  */
        background: #ef3c3cff;
        color: white; 
        padding: 20px 40px; 
        display: flex; 
        justify-content: space-between; }
.navbar h1 { font-size: 24px; }
.back-btn { background: rgba(255,255,255,0.2); color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; }
.container { max-width: 1400px; margin: 30px auto; padding: 0 20px; }
table { width: 100%; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
th, td { padding: 15px; text-align: left; border-bottom: 1px solid #ddd; }
th { background: #f8f9fa; color: #666; font-weight: 600; }
tr:hover { background: #f8f9fa; }
</style></head><body>
<div class="navbar"><h1>Nurse Management - Vikram Hospital</h1><a href="dashboard.php" class="back-btn">← Back</a></div>
<div class="container"><h2 style="margin-bottom: 20px;">All Nurses</h2>
<table><thead><tr><th>Nurse ID</th><th>Name</th><th>Age/Gender</th><th>Mobile</th><th>Address</th><th>Salary</th></tr></thead><tbody>
<?php while($row = $result->fetch_assoc()): ?>
<tr><td><strong>#<?php echo $row['NurseID']; ?></strong></td><td><?php echo $row['Name']; ?></td>
<td><?php echo $row['Age']; ?> yrs / <?php echo $row['Gender']; ?></td>
<td><?php echo $row['MobNo']; ?></td><td><?php echo $row['Address']; ?></td>
<td>₹<?php echo number_format($row['Salary'], 2); ?></td></tr>
<?php endwhile; ?>
</tbody></table></div></body></html>