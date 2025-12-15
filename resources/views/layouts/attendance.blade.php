<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Attendance - Campus Digital">

    <title>Attendance | Campus Digital</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

        /* Content Cards */
        .content-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--shadow-light);
            margin-bottom: 2rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--dark-bg);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-title i {
            color: var(--primary-color);
        }

        /* Date Navigation */
        .date-navigation {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding: 1rem;
            background-color: #f8fafc;
            border-radius: var(--border-radius);
        }

        .date-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-light);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 6px;
            transition: var(--transition);
        }

        .date-btn:hover {
            background-color: #e2e8f0;
            color: var(--primary-color);
        }

        .current-date {
            flex: 1;
            text-align: center;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 1.1rem;
        }

        /* Attendance Stats */
        .attendance-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: #f8fafc;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            text-align: center;
            border-top: 4px solid var(--primary-color);
        }

        .stat-card.present {
            border-top-color: var(--success-color);
        }

        .stat-card.absent {
            border-top-color: var(--danger-color);
        }

        .stat-card.late {
            border-top-color: var(--warning-color);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-card.present .stat-value {
            color: var(--success-color);
        }

        .stat-card.absent .stat-value {
            color: var(--danger-color);
        }

        .stat-card.late .stat-value {
            color: var(--warning-color);
        }

        .stat-label {
            color: var(--text-light);
            font-size: 0.95rem;
        }

        /* Attendance Table */
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-light);
        }

        .attendance-table th {
            text-align: left;
            padding: 1rem 1.5rem;
            background-color: #f8fafc;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.95rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .attendance-table td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-block;
        }

        .status-present {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-absent {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-late {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-holiday {
            background-color: #e0e7ff;
            color: #3730a3;
        }

        /* Month Selector */
        .month-selector {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .month-btn {
            padding: 0.75rem 1.5rem;
            background-color: #f1f5f9;
            border: none;
            border-radius: 8px;
            color: var(--text-dark);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .month-btn:hover {
            background-color: #e2e8f0;
        }

        .month-btn.active {
            background-color: var(--primary-color);
            color: white;
        }

        /* Attendance Calendar */
        .calendar-container {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-light);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .calendar-month {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark-bg);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background-color: #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }

        .calendar-day {
            background-color: white;
            padding: 1rem 0.5rem;
            text-align: center;
            min-height: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .calendar-day.header {
            background-color: #f8fafc;
            font-weight: 600;
            color: var(--text-dark);
            min-height: auto;
            padding: 0.75rem 0.5rem;
        }

        .day-number {
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .day-status {
            font-size: 0.75rem;
            padding: 2px 6px;
            border-radius: 10px;
            margin-top: 4px;
        }

        .day-present .day-status {
            background-color: #d1fae5;
            color: #065f46;
        }

        .day-absent .day-status {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .day-late .day-status {
            background-color: #fef3c7;
            color: #92400e;
        }

        .day-holiday .day-status {
            background-color: #e0e7ff;
            color: #3730a3;
        }

        /* Legend */
        .legend {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .legend-present .legend-color {
            background-color: #10b981;
        }

        .legend-absent .legend-color {
            background-color: #ef4444;
        }

        .legend-late .legend-color {
            background-color: #f59e0b;
        }

        .legend-holiday .legend-color {
            background-color: #8b5cf6;
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
            
            .attendance-stats {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .attendance-table {
                display: block;
                overflow-x: auto;
            }
            
            .calendar-grid {
                grid-template-columns: repeat(7, minmax(40px, 1fr));
            }
            
            .calendar-day {
                padding: 0.5rem 0.25rem;
                min-height: 60px;
            }
            
            .day-number {
                font-size: 0.9rem;
            }
            
            .day-status {
                font-size: 0.7rem;
            }
        }

        @media (max-width: 480px) {
            .attendance-stats {
                grid-template-columns: 1fr;
            }
            
            .month-selector {
                justify-content: center;
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
                    <a href="/dashboard">
                        <i class="fas fa-home nav-icon"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/attendance" class="active">
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
                    <h1>Attendance</h1>
                    <p>Track your attendance records and view your attendance percentage.</p>
                </div>
                
                <div class="top-actions">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
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
            
            <!-- Date Navigation -->
            <div class="date-navigation">
                <button class="date-btn" id="prevDate">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="current-date" id="currentDate">
                    {{ date('F j, Y') }}
                </div>
                <button class="date-btn" id="nextDate">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            
            <!-- Attendance Stats -->
            <div class="attendance-stats">
                <div class="stat-card present">
                    <div class="stat-value" id="presentDays">42</div>
                    <div class="stat-label">Days Present</div>
                </div>
                <div class="stat-card absent">
                    <div class="stat-value" id="absentDays">3</div>
                    <div class="stat-label">Days Absent</div>
                </div>
                <div class="stat-card late">
                    <div class="stat-value" id="lateDays">2</div>
                    <div class="stat-label">Days Late</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="attendancePercentage">92%</div>
                    <div class="stat-label">Overall Attendance</div>
                </div>
            </div>
            
            <!-- Today's Attendance -->
            <div class="content-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fas fa-calendar-day"></i>
                        Today's Attendance ({{ date('F j, Y') }})
                    </h2>
                </div>
                
                <div class="attendance-table-container">
                    <table class="attendance-table">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Web Development</strong>
                                    <div style="font-size: 0.9rem; color: var(--text-light);">CS 101</div>
                                </td>
                                <td>9:00 AM - 10:00 AM</td>
                                <td>
                                    <span class="status-badge status-present">Present</span>
                                </td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Database Systems</strong>
                                    <div style="font-size: 0.9rem; color: var(--text-light);">CS 201</div>
                                </td>
                                <td>11:00 AM - 12:30 PM</td>
                                <td>
                                    <span class="status-badge status-present">Present</span>
                                </td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Algorithms</strong>
                                    <div style="font-size: 0.9rem; color: var(--text-light);">CS 301</div>
                                </td>
                                <td>2:00 PM - 3:00 PM</td>
                                <td>
                                    <span class="status-badge status-late">Late (5 mins)</span>
                                </td>
                                <td>Traffic delay</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Mathematics</strong>
                                    <div style="font-size: 0.9rem; color: var(--text-light);">MATH 101</div>
                                </td>
                                <td>4:00 PM - 5:00 PM</td>
                                <td>
                                    <span class="status-badge status-present">Present</span>
                                </td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Monthly View -->
            <div class="content-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fas fa-calendar-alt"></i>
                        Monthly Attendance Overview
                    </h2>
                    <div class="month-selector">
                        <button class="month-btn" data-month="0">Jan</button>
                        <button class="month-btn" data-month="1">Feb</button>
                        <button class="month-btn" data-month="2">Mar</button>
                        <button class="month-btn" data-month="3">Apr</button>
                        <button class="month-btn" data-month="4">May</button>
                        <button class="month-btn" data-month="5">Jun</button>
                        <button class="month-btn" data-month="6">Jul</button>
                        <button class="month-btn" data-month="7">Aug</button>
                        <button class="month-btn active" data-month="8">Sep</button>
                        <button class="month-btn" data-month="9">Oct</button>
                        <button class="month-btn" data-month="10">Nov</button>
                        <button class="month-btn" data-month="11">Dec</button>
                    </div>
                </div>
                
                <div class="calendar-container">
                    <div class="calendar-header">
                        <button class="date-btn prev-month">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="calendar-month">September 2023</div>
                        <button class="date-btn next-month">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    
                    <div class="calendar-grid">
                        <!-- Day Headers -->
                        <div class="calendar-day header">Sun</div>
                        <div class="calendar-day header">Mon</div>
                        <div class="calendar-day header">Tue</div>
                        <div class="calendar-day header">Wed</div>
                        <div class="calendar-day header">Thu</div>
                        <div class="calendar-day header">Fri</div>
                        <div class="calendar-day header">Sat</div>
                        
                        <!-- Calendar Days -->
                        <!-- Empty days for start of month -->
                        <div class="calendar-day"></div>
                        <div class="calendar-day"></div>
                        <div class="calendar-day"></div>
                        <div class="calendar-day"></div>
                        <div class="calendar-day"></div>
                        
                        <!-- September 1-30 -->
                        <div class="calendar-day day-present">
                            <div class="day-number">1</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">2</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-holiday">
                            <div class="day-number">3</div>
                            <div class="day-status">Holiday</div>
                        </div>
                        <div class="calendar-day day-holiday">
                            <div class="day-number">4</div>
                            <div class="day-status">Holiday</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">5</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">6</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">7</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">8</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">9</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-absent">
                            <div class="day-number">10</div>
                            <div class="day-status">Absent</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">11</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">12</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-late">
                            <div class="day-number">13</div>
                            <div class="day-status">Late</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">14</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">15</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">16</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-holiday">
                            <div class="day-number">17</div>
                            <div class="day-status">Holiday</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">18</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">19</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">20</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">21</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">22</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">23</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-absent">
                            <div class="day-number">24</div>
                            <div class="day-status">Absent</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">25</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">26</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">27</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">28</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-present">
                            <div class="day-number">29</div>
                            <div class="day-status">Present</div>
                        </div>
                        <div class="calendar-day day-late">
                            <div class="day-number">30</div>
                            <div class="day-status">Late</div>
                        </div>
                    </div>
                    
                    <!-- Legend -->
                    <div class="legend">
                        <div class="legend-item legend-present">
                            <span class="legend-color"></span>
                            <span>Present</span>
                        </div>
                        <div class="legend-item legend-absent">
                            <span class="legend-color"></span>
                            <span>Absent</span>
                        </div>
                        <div class="legend-item legend-late">
                            <span class="legend-color"></span>
                            <span>Late</span>
                        </div>
                        <div class="legend-item legend-holiday">
                            <span class="legend-color"></span>
                            <span>Holiday/Weekend</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Attendance History -->
            <div class="content-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="fas fa-history"></i>
                        Recent Attendance History
                    </h2>
                </div>
                
                <div class="attendance-table-container">
                    <table class="attendance-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Course</th>
                                <th>Status</th>
                                <th>Class Time</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nov 10, 2023</td>
                                <td>Web Development (CS 101)</td>
                                <td><span class="status-badge status-present">Present</span></td>
                                <td>9:00 AM</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Nov 9, 2023</td>
                                <td>Database Systems (CS 201)</td>
                                <td><span class="status-badge status-present">Present</span></td>
                                <td>11:00 AM</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Nov 8, 2023</td>
                                <td>Algorithms (CS 301)</td>
                                <td><span class="status-badge status-late">Late (10 mins)</span></td>
                                <td>2:00 PM</td>
                                <td>Traffic</td>
                            </tr>
                            <tr>
                                <td>Nov 7, 2023</td>
                                <td>Mathematics (MATH 101)</td>
                                <td><span class="status-badge status-present">Present</span></td>
                                <td>4:00 PM</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Nov 6, 2023</td>
                                <td>Web Development (CS 101)</td>
                                <td><span class="status-badge status-absent">Absent</span></td>
                                <td>9:00 AM</td>
                                <td>Medical Leave</td>
                            </tr>
                            <tr>
                                <td>Nov 3, 2023</td>
                                <td>Database Systems (CS 201)</td>
                                <td><span class="status-badge status-present">Present</span></td>
                                <td>11:00 AM</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Nov 2, 2023</td>
                                <td>Algorithms (CS 301)</td>
                                <td><span class="status-badge status-present">Present</span></td>
                                <td>2:00 PM</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Nov 1, 2023</td>
                                <td>Mathematics (MATH 101)</td>
                                <td><span class="status-badge status-present">Present</span></td>
                                <td>4:00 PM</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Make sidebar links active on click
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('.nav-links a').forEach(item => {
                    item.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Date Navigation
        let currentDate = new Date();
        
        function updateDateDisplay() {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('currentDate').textContent = currentDate.toLocaleDateString('en-US', options);
        }
        
        document.getElementById('prevDate').addEventListener('click', function() {
            currentDate.setDate(currentDate.getDate() - 1);
            updateDateDisplay();
        });
        
        document.getElementById('nextDate').addEventListener('click', function() {
            currentDate.setDate(currentDate.getDate() + 1);
            updateDateDisplay();
        });
        
        // Month selector
        document.querySelectorAll('.month-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.month-btn').forEach(b => {
                    b.classList.remove('active');
                });
                this.classList.add('active');
                
                const monthIndex = parseInt(this.dataset.month);
                const monthNames = [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ];
                
                document.querySelector('.calendar-month').textContent = `${monthNames[monthIndex]} 2023`;
            });
        });
        
        // Calendar navigation
        document.querySelector('.prev-month').addEventListener('click', function() {
            alert('Previous month clicked - Implement month navigation here');
        });
        
        document.querySelector('.next-month').addEventListener('click', function() {
            alert('Next month clicked - Implement month navigation here');
        });
        
        // Notification button
        document.querySelector('.notification-btn').addEventListener('click', function() {
            alert('You have 3 new notifications');
        });
        
        // Initialize
        updateDateDisplay();
    </script>
</body>
</html>