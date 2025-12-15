<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Student Dashboard - Campus Digital">

    <title>Student Dashboard | Campus Digital</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js for analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #7c3aed;
            --accent-color: #06b6d4;
            --dark-bg: #0f172a;
            --light-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --text-lighter: #94a3b8;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --border-radius: 12px;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-light: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: #f1f5f9;
            min-height: 100vh;
        }

        /* Dashboard Layout */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background-color: var(--dark-bg);
            color: white;
            padding: 1.5rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: var(--transition);
            z-index: 100;
        }

        .logo-area {
            padding: 0 1.5rem 2rem;
            border-bottom: 1px solid #334155;
            margin-bottom: 1.5rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 1.4rem;
            color: white;
            text-decoration: none;
        }

        .logo-icon {
            color: var(--secondary-color);
            font-size: 1.8rem;
        }

        .user-profile {
            padding: 0 1.5rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #334155;
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .user-info h3 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .user-info p {
            font-size: 0.85rem;
            color: var(--text-lighter);
            background-color: rgba(255, 255, 255, 0.1);
            padding: 2px 8px;
            border-radius: 20px;
            display: inline-block;
        }

        .nav-links {
            list-style: none;
            padding: 0 1rem;
        }

        .nav-links li {
            margin-bottom: 4px;
        }

        .nav-links a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.85rem 1rem;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 8px;
            transition: var(--transition);
        }

        .nav-links a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-links a.active {
            background-color: var(--primary-color);
            color: white;
        }

        .nav-icon {
            width: 20px;
            text-align: center;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 1.5rem;
            transition: var(--transition);
        }

        /* Top Bar */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 2rem;
        }

        .page-title h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-bg);
        }

        .page-title p {
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .top-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .notification-btn {
            position: relative;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-light);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: var(--transition);
        }

        .notification-btn:hover {
            background-color: #f1f5f9;
            color: var(--primary-color);
        }

        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: var(--danger-color);
            color: white;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: var(--danger-color);
            color: white;
            border: none;
            padding: 0.7rem 1.2rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .logout-btn:hover {
            background-color: #dc2626;
        }

        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
        }

        .welcome-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .welcome-text h2 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .welcome-text p {
            opacity: 0.9;
            max-width: 600px;
        }

        .semester-info {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            text-align: center;
        }

        .semester-info .label {
            font-size: 0.85rem;
            opacity: 0.8;
            margin-bottom: 4px;
        }

        .semester-info .value {
            font-size: 1.2rem;
            font-weight: 600;
        }

        /* Stats Overview */
        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-light);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: var(--transition);
            border-left: 4px solid var(--success-color);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
        }

        .stat-card.attendance {
            border-left-color: var(--primary-color);
        }

        .stat-card.assignments {
            border-left-color: var(--warning-color);
        }

        .stat-card.grades {
            border-left-color: var(--success-color);
        }

        .stat-card.fees {
            border-left-color: var(--danger-color);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-card.attendance .stat-icon {
            background-color: var(--primary-color);
        }

        .stat-card.assignments .stat-icon {
            background-color: var(--warning-color);
        }

        .stat-card.grades .stat-icon {
            background-color: var(--success-color);
        }

        .stat-card.fees .stat-icon {
            background-color: var(--danger-color);
        }

        .stat-info h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-bg);
            margin-bottom: 4px;
        }

        .stat-info p {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 1100px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Charts and Analytics */
        .dashboard-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-light);
            margin-bottom: 1.5rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark-bg);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title i {
            color: var(--primary-color);
        }

        .view-all {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .view-all:hover {
            text-decoration: underline;
        }

        /* Attendance Chart */
        .chart-container {
            height: 250px;
            position: relative;
            margin-bottom: 1rem;
        }

        /* Pending Assignments */
        .assignments-list {
            list-style: none;
        }

        .assignment-item {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: var(--transition);
        }

        .assignment-item:hover {
            background-color: #f8fafc;
            border-radius: 8px;
        }

        .assignment-item:last-child {
            border-bottom: none;
        }

        .assignment-info h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .assignment-info p {
            font-size: 0.9rem;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .assignment-course {
            color: var(--primary-color);
            font-weight: 500;
        }

        .assignment-deadline {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--warning-color);
            font-size: 0.85rem;
        }

        .assignment-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-submitted {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-overdue {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Upcoming Quizzes */
        .quizzes-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }

        .quiz-card {
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 1.25rem;
            border-left: 4px solid var(--secondary-color);
            transition: var(--transition);
        }

        .quiz-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-light);
        }

        .quiz-card h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .quiz-details {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 1rem;
        }

        .quiz-detail {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .quiz-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
            border: none;
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .btn-outline:hover {
            background-color: rgba(37, 99, 235, 0.1);
        }

        /* Recent Grades */
        .grades-table {
            width: 100%;
            border-collapse: collapse;
        }

        .grades-table th {
            text-align: left;
            padding: 0.75rem 1rem;
            border-bottom: 2px solid #e2e8f0;
            color: var(--text-light);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .grades-table td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .grade-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-block;
        }

        .grade-a {
            background-color: #d1fae5;
            color: #065f46;
        }

        .grade-b {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .grade-c {
            background-color: #fef3c7;
            color: #92400e;
        }

        /* Fee Status */
        .fee-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background-color: #f8fafc;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .fee-details h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .fee-details p {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .fee-amount {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark-bg);
        }

        .fee-paid {
            color: var(--success-color);
        }

        .fee-pending {
            color: var(--danger-color);
        }

        /* Today's Classes */
        .classes-list {
            list-style: none;
        }

        .class-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .class-item:last-child {
            border-bottom: none;
        }

        .class-time {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 80px;
        }

        .class-time .time {
            font-weight: 600;
            font-size: 1rem;
        }

        .class-time .duration {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .class-details {
            flex: 1;
            padding: 0 1rem;
        }

        .class-details h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .class-details p {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .class-room {
            color: var(--primary-color);
            font-weight: 500;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .action-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            text-align: center;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
            background-color: var(--primary-color);
            color: white;
        }

        .action-card:hover .action-icon {
            background-color: white;
            color: var(--primary-color);
        }

        .action-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background-color: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .action-card h4 {
            font-size: 1rem;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 70px;
                overflow: visible;
            }
            
            .logo span, .user-info, .nav-links span {
                display: none;
            }
            
            .logo-area, .user-profile {
                padding: 0 1rem 1.5rem;
                justify-content: center;
            }
            
            .main-content {
                margin-left: 70px;
            }
            
            .nav-links a {
                justify-content: center;
                padding: 0.85rem;
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 1rem 0;
            }
            
            .nav-links {
                display: flex;
                overflow-x: auto;
                padding: 0 0.5rem;
            }
            
            .nav-links li {
                flex-shrink: 0;
            }
            
            .nav-links a {
                padding: 0.5rem 1rem;
            }
            
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .top-actions {
                width: 100%;
                justify-content: space-between;
            }
            
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .welcome-header {
                flex-direction: column;
                gap: 1rem;
            }
        }

        @media (max-width: 480px) {
            .stats-overview {
                grid-template-columns: 1fr;
            }
            
            .quizzes-list {
                grid-template-columns: 1fr;
            }
            
            .quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo-area">
                <a href="/dashboard" class="logo">
                    <i class="fas fa-graduation-cap logo-icon"></i>
                    <span>Campus Digital</span>
                </a>
            </div>
            
            <div class="user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="user-info">
                    <h3>{{ auth()->user()->name }}</h3>
                    <p>Student</p>
                </div>
            </div>
            
            <ul class="nav-links">
                <li>
                    <a href="/dashboard" class="active">
                        <i class="fas fa-home nav-icon"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/attendance">
                        <i class="fas fa-calendar-check nav-icon"></i>
                        <span>Attendance</span>
                    </a>
                </li>
                <li>
                    <a href="/assignments">
                        <i class="fas fa-tasks nav-icon"></i>
                        <span>Assignments</span>
                    </a>
                </li>
                <li>
                    <a href="/quizzes">
                        <i class="fas fa-question-circle nav-icon"></i>
                        <span>Quizzes</span>
                    </a>
                </li>
                <li>
                    <a href="/grades">
                        <i class="fas fa-chart-line nav-icon"></i>
                        <span>Grades</span>
                    </a>
                </li>
                <li>
                    <a href="/timetable">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <span>Timetable</span>
                    </a>
                </li>
                <li>
                    <a href="/fee">
                        <i class="fas fa-credit-card nav-icon"></i>
                        <span>Fees</span>
                    </a>
                </li>
                <li>
                    <a href="/profile">
                        <i class="fas fa-user-circle nav-icon"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="/settings">
                        <i class="fas fa-cog nav-icon"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="page-title">
                    <h1>Student Dashboard</h1>
                    <p>Welcome back! Track your attendance, submit assignments, and monitor your academic progress.</p>
                </div>
                
                <div class="top-actions">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">5</span>
                    </button>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Welcome Section -->
            <div class="welcome-section">
                <div class="welcome-header">
                    <div class="welcome-text">
                        <h2>Hello, {{ auth()->user()->name }}!</h2>
                        <p>Welcome to your student dashboard. Here's an overview of your academic progress for this semester.</p>
                    </div>
                    <div class="semester-info">
                        <div class="label">Current Semester</div>
                        <div class="value">Fall 2023</div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Overview -->
            <div class="stats-overview">
                <div class="stat-card attendance">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="attendance-percentage">92%</h3>
                        <p>Overall Attendance</p>
                    </div>
                </div>
                
                <div class="stat-card assignments">
                    <div class="stat-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="pending-assignments">3</h3>
                        <p>Pending Assignments</p>
                    </div>
                </div>
                
                <div class="stat-card grades">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="avg-grade">87%</h3>
                        <p>Average Grade</p>
                    </div>
                </div>
                
                <div class="stat-card fees">
                    <div class="stat-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="fee-status">$1,200</h3>
                        <p>Balance Due</p>
                    </div>
                </div>
            </div>
            
            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <!-- Left Column -->
                <div>
                    <!-- Attendance Chart -->
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar"></i>
                                Attendance Overview
                            </h3>
                            <a href="/attendance" class="view-all">View Details →</a>
                        </div>
                        <div class="chart-container">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>
                    
                    <!-- Pending Assignments -->
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-tasks"></i>
                                Pending Assignments
                            </h3>
                            <a href="/assignments" class="view-all">View All →</a>
                        </div>
                        <ul class="assignments-list">
                            <li class="assignment-item">
                                <div class="assignment-info">
                                    <h4>Web Development Project</h4>
                                    <p>
                                        <span class="assignment-course">CS 101</span>
                                        <span class="assignment-deadline">
                                            <i class="far fa-clock"></i>
                                            Due: Tomorrow
                                        </span>
                                    </p>
                                </div>
                                <span class="assignment-status status-pending">Pending</span>
                            </li>
                            <li class="assignment-item">
                                <div class="assignment-info">
                                    <h4>Database Design Assignment</h4>
                                    <p>
                                        <span class="assignment-course">CS 201</span>
                                        <span class="assignment-deadline">
                                            <i class="far fa-clock"></i>
                                            Due: 3 days
                                        </span>
                                    </p>
                                </div>
                                <span class="assignment-status status-pending">Pending</span>
                            </li>
                            <li class="assignment-item">
                                <div class="assignment-info">
                                    <h4>Algorithms Problem Set</h4>
                                    <p>
                                        <span class="assignment-course">CS 301</span>
                                        <span class="assignment-deadline">
                                            <i class="far fa-clock"></i>
                                            Due: 5 days
                                        </span>
                                    </p>
                                </div>
                                <span class="assignment-status status-submitted">Submitted</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Upcoming Quizzes -->
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-question-circle"></i>
                                Upcoming Quizzes
                            </h3>
                            <a href="/quizzes" class="view-all">View All →</a>
                        </div>
                        <div class="quizzes-list">
                            <div class="quiz-card">
                                <h4>Mathematics Midterm</h4>
                                <div class="quiz-details">
                                    <div class="quiz-detail">
                                        <i class="far fa-calendar"></i>
                                        <span>Nov 15, 2023</span>
                                    </div>
                                    <div class="quiz-detail">
                                        <i class="far fa-clock"></i>
                                        <span>10:00 AM - 11:30 AM</span>
                                    </div>
                                    <div class="quiz-detail">
                                        <i class="fas fa-book"></i>
                                        <span>Chapters 1-5</span>
                                    </div>
                                </div>
                                <div class="quiz-actions">
                                    <a href="#" class="btn btn-primary">Start Quiz</a>
                                    <a href="#" class="btn btn-outline">Review</a>
                                </div>
                            </div>
                            <div class="quiz-card">
                                <h4>Physics Quiz</h4>
                                <div class="quiz-details">
                                    <div class="quiz-detail">
                                        <i class="far fa-calendar"></i>
                                        <span>Nov 18, 2023</span>
                                    </div>
                                    <div class="quiz-detail">
                                        <i class="far fa-clock"></i>
                                        <span>2:00 PM - 3:00 PM</span>
                                    </div>
                                    <div class="quiz-detail">
                                        <i class="fas fa-book"></i>
                                        <span>Chapter 3</span>
                                    </div>
                                </div>
                                <div class="quiz-actions">
                                    <a href="#" class="btn btn-primary">Prepare</a>
                                    <a href="#" class="btn btn-outline">Notes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div>
                    <!-- Today's Classes -->
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-calendar-day"></i>
                                Today's Classes
                            </h3>
                            <a href="/timetable" class="view-all">Full Timetable →</a>
                        </div>
                        <ul class="classes-list">
                            <li class="class-item">
                                <div class="class-time">
                                    <span class="time">9:00 AM</span>
                                    <span class="duration">1 hr</span>
                                </div>
                                <div class="class-details">
                                    <h4>Web Development</h4>
                                    <p>Prof. Johnson • <span class="class-room">Room 302</span></p>
                                </div>
                            </li>
                            <li class="class-item">
                                <div class="class-time">
                                    <span class="time">11:00 AM</span>
                                    <span class="duration">1.5 hrs</span>
                                </div>
                                <div class="class-details">
                                    <h4>Database Systems</h4>
                                    <p>Prof. Smith • <span class="class-room">Lab 105</span></p>
                                </div>
                            </li>
                            <li class="class-item">
                                <div class="class-time">
                                    <span class="time">2:00 PM</span>
                                    <span class="duration">1 hr</span>
                                </div>
                                <div class="class-details">
                                    <h4>Algorithms</h4>
                                    <p>Prof. Williams • <span class="class-room">Room 415</span></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Recent Grades -->
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-graduation-cap"></i>
                                Recent Grades
                            </h3>
                            <a href="/grades" class="view-all">View All →</a>
                        </div>
                        <table class="grades-table">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Assignment</th>
                                    <th>Grade</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>CS 101</td>
                                    <td>Web Dev Project</td>
                                    <td><span class="grade-badge grade-a">A (95%)</span></td>
                                    <td>Nov 10</td>
                                </tr>
                                <tr>
                                    <td>CS 201</td>
                                    <td>Database Quiz</td>
                                    <td><span class="grade-badge grade-b">B+ (88%)</span></td>
                                    <td>Nov 8</td>
                                </tr>
                                <tr>
                                    <td>CS 301</td>
                                    <td>Midterm Exam</td>
                                    <td><span class="grade-badge grade-a">A- (90%)</span></td>
                                    <td>Nov 5</td>
                                </tr>
                                <tr>
                                    <td>MATH 101</td>
                                    <td>Calculus Assignment</td>
                                    <td><span class="grade-badge grade-b">B (85%)</span></td>
                                    <td>Nov 3</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Fee Status -->
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-credit-card"></i>
                                Fee Status
                            </h3>
                            <a href="/fee" class="view-all">Details →</a>
                        </div>
                        <div class="fee-status">
                            <div class="fee-details">
                                <h4>Fall 2023 Semester</h4>
                                <p>Due Date: Dec 15, 2023</p>
                            </div>
                            <div class="fee-amount fee-pending">
                                $1,200
                            </div>
                        </div>
                        <div class="fee-status">
                            <div class="fee-details">
                                <h4>Paid Amount</h4>
                                <p>Last Payment: Oct 15, 2023</p>
                            </div>
                            <div class="fee-amount fee-paid">
                                $3,800
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="quick-actions">
                    <a href="/attendance" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h4>View Attendance</h4>
                    </a>
                    <a href="/assignments/submit" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-upload"></i>
                        </div>
                        <h4>Submit Assignment</h4>
                    </a>
                    <a href="/quizzes/take" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h4>Take Quiz</h4>
                    </a>
                    <a href="/fee/pay" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <h4>Pay Fees</h4>
                    </a>
                    <a href="/timetable" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h4>View Timetable</h4>
                    </a>
                    <a href="/profile" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <h4>Update Profile</h4>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Initialize Attendance Chart
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7', 'Week 8'],
                datasets: [{
                    label: 'Attendance %',
                    data: [85, 88, 92, 90, 93, 95, 94, 92],
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 75,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    }
                }
            }
        });

        // Update current time in welcome message
        function updateWelcomeTime() {
            const now = new Date();
            const hours = now.getHours();
            let timeOfDay;
            
            if (hours < 12) timeOfDay = "Morning";
            else if (hours < 17) timeOfDay = "Afternoon";
            else timeOfDay = "Evening";
            
            document.querySelector('.welcome-text h2').innerHTML = `Good ${timeOfDay}, {{ auth()->user()->name }}!`;
        }

        // Simulate dynamic stats update
        function updateStats() {
            // Randomize stats slightly for demo
            const attendance = 92 + Math.floor(Math.random() * 3) - 1;
            const assignments = Math.max(0, 3 + Math.floor(Math.random() * 3) - 1);
            const grade = 87 + Math.floor(Math.random() * 3) - 1;
            const fee = 1200 + Math.floor(Math.random() * 100) - 50;
            
            document.getElementById('attendance-percentage').textContent = `${attendance}%`;
            document.getElementById('pending-assignments').textContent = assignments;
            document.getElementById('avg-grade').textContent = `${grade}%`;
            document.getElementById('fee-status').textContent = `$${fee}`;
            
            // Update chart with new data
            const newData = attendanceChart.data.datasets[0].data.map(value => {
                const variation = Math.floor(Math.random() * 3) - 1;
                return Math.max(85, Math.min(100, value + variation));
            });
            attendanceChart.data.datasets[0].data = newData;
            attendanceChart.update();
        }

        // Make sidebar links active on click
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('.nav-links a').forEach(item => {
                    item.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Notification button functionality
        document.querySelector('.notification-btn').addEventListener('click', function() {
            alert('You have 5 new notifications:\n1. New assignment posted\n2. Quiz reminder\n3. Fee payment reminder\n4. Attendance updated\n5. Grade posted');
        });

        // Initialize
        updateWelcomeTime();
        
        // Update stats every 60 seconds for demo
        setInterval(updateStats, 60000);
        
        // Simulate initial random variation
        setTimeout(updateStats, 1000);
    </script>
</body>
</html>