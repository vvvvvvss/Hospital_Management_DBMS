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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .welcome-container {
            background: white;
            padding: 60px 80px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            text-align: center;
            max-width: 700px;
            animation: fadeIn 0.8s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logo {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        h1 {
            color: #333;
            font-size: 36px;
            margin-bottom: 10px;
        }
        
        .subtitle {
            color: #666;
            font-size: 18px;
            margin-bottom: 30px;
        }
        
        .project-info {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: left;
        }
        
        .project-info h3 {
            color: #667eea;
            margin-bottom: 15px;
            text-align: center;
        }
        
        .creator-info {
            margin: 15px 0;
            padding: 15px;
            background: white;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        
        .creator-info p {
            color: #555;
            line-height: 1.8;
            margin: 5px 0;
        }
        
        .creator-info strong {
            color: #333;
        }
        
        .course-info {
            text-align: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
        }
        
        .course-info p {
            color: #666;
            font-size: 16px;
            margin: 5px 0;
        }
        
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px 50px;
            border: none;
            border-radius: 50px;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            text-decoration: none;
            display: inline-block;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
        }
        
        .features {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        
        .feature-item {
            padding: 15px;
            background: #f0f0f0;
            border-radius: 10px;
        }
        
        .feature-item h4 {
            color: #667eea;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .feature-item p {
            color: #666;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="logo">🏥</div>
        <h1>Hospital Management System</h1>
        <p class="subtitle">DBMS Lab Mini Project</p>
        
        <div class="project-info">
            <h3>👥 Project Created By</h3>
            
            <div class="creator-info">
                <p><strong>Name:</strong> Shivani</p>
                <p><strong>USN:</strong> U25UV23T006049 </p>
            </div>
            
            <div class="creator-info">
                <p><strong>Name:</strong> Varsha Shubhashri M</p>
                <p><strong>USN:</strong> U25UV23T006060</p>
            </div>
            
            <div class="course-info">
                <p><strong>Course:</strong> AIML 5th Semester</p>
                <p><strong>Subject:</strong> Database Management Systems Lab</p>
            </div>
        </div>
        
        <a href="login.php" class="btn">
            🔐 Login to Dashboard
        </a>
        
        <div class="features">
            <div class="feature-item">
                <h4>👨‍⚕️ Patients</h4>
                <p>Manage Records</p>
            </div>
            <div class="feature-item">
                <h4>🩺 Doctors</h4>
                <p>Staff Management</p>
            </div>
            <div class="feature-item">
                <h4>📋 Reports</h4>
                <p>Test Results</p>
            </div>
            <div class="feature-item">
                <h4>💰 Bills</h4>
                <p>Payment Tracking</p>
            </div>
            <div class="feature-item">
                <h4>👩‍⚕️ Nurses</h4>
                <p>Staff Records</p>
            </div>
            <div class="feature-item">
                <h4>📊 Analytics</h4>
                <p>Dashboard View</p>
            </div>
        </div>
    </div>
</body>
</html>