<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Campus Digital Utility App - Streamline academic operations for students and teachers">

        <title>Campus Digital | Academic Management Platform</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Styles -->
        <style>
            /* Custom Styles */
            :root {
                --primary-color: #2563eb;
                --primary-dark: #1d4ed8;
                --secondary-color: #7c3aed;
                --accent-color: #06b6d4;
                --dark-bg: #0f172a;
                --light-bg: #f8fafc;
                --text-dark: #1e293b;
                --text-light: #64748b;
                --success-color: #10b981;
                --warning-color: #f59e0b;
                --border-radius: 12px;
                --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
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
                background-color: var(--light-bg);
            }

            /* Navigation */
            .nav-container {
                background-color: white;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                position: fixed;
                top: 0;
                width: 100%;
                z-index: 1000;
            }

            .nav-content {
                max-width: 1200px;
                margin: 0 auto;
                padding: 1rem 2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .logo {
                display: flex;
                align-items: center;
                gap: 10px;
                font-weight: 700;
                font-size: 1.5rem;
                color: var(--primary-color);
            }

            .logo-icon {
                color: var(--secondary-color);
                font-size: 1.8rem;
            }

            .nav-links {
                display: flex;
                gap: 2rem;
                align-items: center;
            }

            .nav-link {
                color: var(--text-dark);
                text-decoration: none;
                font-weight: 500;
                transition: var(--transition);
            }

            .nav-link:hover {
                color: var(--primary-color);
            }

            .auth-buttons {
                display: flex;
                gap: 1rem;
            }

            .btn {
                padding: 0.7rem 1.5rem;
                border-radius: var(--border-radius);
                font-weight: 600;
                cursor: pointer;
                transition: var(--transition);
                text-decoration: none;
                display: inline-block;
                border: none;
                font-size: 1rem;
            }

            .btn-primary {
                background-color: var(--primary-color);
                color: white;
            }

            .btn-primary:hover {
                background-color: var(--primary-dark);
                transform: translateY(-2px);
                box-shadow: var(--shadow);
            }

            .btn-secondary {
                background-color: transparent;
                color: var(--primary-color);
                border: 2px solid var(--primary-color);
            }

            .btn-secondary:hover {
                background-color: rgba(37, 99, 235, 0.1);
                transform: translateY(-2px);
            }

            /* Hero Section */
            .hero {
                padding: 8rem 2rem 6rem;
                background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
                text-align: center;
            }

            .hero-content {
                max-width: 800px;
                margin: 0 auto;
            }

            .hero h1 {
                font-size: 3.5rem;
                font-weight: 800;
                line-height: 1.2;
                margin-bottom: 1.5rem;
                background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .hero p {
                font-size: 1.25rem;
                color: var(--text-light);
                margin-bottom: 2.5rem;
                max-width: 700px;
                margin-left: auto;
                margin-right: auto;
            }

            .hero-buttons {
                display: flex;
                gap: 1rem;
                justify-content: center;
                flex-wrap: wrap;
            }

            .highlight {
                background-color: rgba(37, 99, 235, 0.1);
                padding: 0.2rem 0.5rem;
                border-radius: 6px;
                color: var(--primary-color);
                font-weight: 600;
            }

            /* Features Section */
            .section {
                padding: 5rem 2rem;
                max-width: 1200px;
                margin: 0 auto;
            }

            .section-title {
                text-align: center;
                margin-bottom: 4rem;
            }

            .section-title h2 {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
                color: var(--dark-bg);
            }

            .section-title p {
                color: var(--text-light);
                font-size: 1.1rem;
                max-width: 700px;
                margin: 0 auto;
            }

            /* Role Cards */
            .roles-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 2.5rem;
                margin-bottom: 6rem;
            }

            .role-card {
                background-color: white;
                border-radius: var(--border-radius);
                padding: 2.5rem;
                box-shadow: var(--shadow);
                transition: var(--transition);
                border-top: 5px solid var(--primary-color);
            }

            .role-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            .role-card.student {
                border-top-color: var(--success-color);
            }

            .role-card.teacher {
                border-top-color: var(--warning-color);
            }

            .role-header {
                display: flex;
                align-items: center;
                margin-bottom: 1.5rem;
            }

            .role-icon {
                width: 70px;
                height: 70px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 1.5rem;
                font-size: 1.8rem;
            }

            .student .role-icon {
                background-color: rgba(16, 185, 129, 0.1);
                color: var(--success-color);
            }

            .teacher .role-icon {
                background-color: rgba(245, 158, 11, 0.1);
                color: var(--warning-color);
            }

            .role-title {
                font-size: 1.8rem;
                font-weight: 700;
                color: var(--dark-bg);
            }

            .role-description {
                color: var(--text-light);
                margin-bottom: 2rem;
            }

            .features-list {
                list-style: none;
            }

            .features-list li {
                margin-bottom: 1rem;
                display: flex;
                align-items: flex-start;
            }

            .features-list i {
                color: var(--success-color);
                margin-right: 0.75rem;
                margin-top: 0.25rem;
                font-size: 1.1rem;
            }

            /* Key Features */
            .features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2rem;
                margin-top: 3rem;
            }

            .feature-card {
                background-color: white;
                border-radius: var(--border-radius);
                padding: 2rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                transition: var(--transition);
            }

            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: var(--shadow);
            }

            .feature-icon {
                width: 60px;
                height: 60px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1.5rem;
                font-size: 1.5rem;
                color: white;
            }

            .feature-icon.attendance {
                background-color: var(--primary-color);
            }

            .feature-icon.assignments {
                background-color: var(--secondary-color);
            }

            .feature-icon.quizzes {
                background-color: var(--accent-color);
            }

            .feature-icon.fees {
                background-color: var(--success-color);
            }

            .feature-card h3 {
                font-size: 1.4rem;
                font-weight: 600;
                margin-bottom: 0.75rem;
                color: var(--dark-bg);
            }

            .feature-card p {
                color: var(--text-light);
            }

            /* CTA Section */
            .cta-section {
                background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
                color: white;
                padding: 5rem 2rem;
                text-align: center;
                border-radius: var(--border-radius);
                margin: 4rem auto;
                max-width: 1200px;
            }

            .cta-section h2 {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }

            .cta-section p {
                font-size: 1.2rem;
                max-width: 700px;
                margin: 0 auto 2.5rem;
                opacity: 0.9;
            }

            .cta-buttons {
                display: flex;
                gap: 1rem;
                justify-content: center;
                flex-wrap: wrap;
            }

            .btn-light {
                background-color: white;
                color: var(--primary-color);
            }

            .btn-light:hover {
                background-color: #f1f5f9;
                transform: translateY(-2px);
                box-shadow: var(--shadow);
            }

            .btn-outline-light {
                background-color: transparent;
                color: white;
                border: 2px solid white;
            }

            .btn-outline-light:hover {
                background-color: rgba(255, 255, 255, 0.1);
                transform: translateY(-2px);
            }

            /* Footer */
            .footer {
                background-color: var(--dark-bg);
                color: white;
                padding: 4rem 2rem 2rem;
            }

            .footer-content {
                max-width: 1200px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 3rem;
                margin-bottom: 3rem;
            }

            .footer-column h3 {
                font-size: 1.3rem;
                margin-bottom: 1.5rem;
                position: relative;
                padding-bottom: 0.75rem;
            }

            .footer-column h3:after {
                content: '';
                position: absolute;
                left: 0;
                bottom: 0;
                width: 50px;
                height: 3px;
                background-color: var(--primary-color);
            }

            .footer-links {
                list-style: none;
            }

            .footer-links li {
                margin-bottom: 0.75rem;
            }

            .footer-links a {
                color: #cbd5e1;
                text-decoration: none;
                transition: var(--transition);
            }

            .footer-links a:hover {
                color: white;
                padding-left: 5px;
            }

            .copyright {
                text-align: center;
                padding-top: 2rem;
                border-top: 1px solid #334155;
                color: #94a3b8;
                font-size: 0.9rem;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .nav-content {
                    flex-direction: column;
                    gap: 1rem;
                }
                
                .nav-links {
                    flex-wrap: wrap;
                    justify-content: center;
                    gap: 1rem;
                }
                
                .hero h1 {
                    font-size: 2.5rem;
                }
                
                .hero p {
                    font-size: 1.1rem;
                }
                
                .roles-container {
                    grid-template-columns: 1fr;
                }
                
                .role-card {
                    padding: 1.8rem;
                }
                
                .section {
                    padding: 3rem 1.5rem;
                }
                
                .section-title h2 {
                    font-size: 2rem;
                }
            }

            @media (max-width: 480px) {
                .hero-buttons, .cta-buttons {
                    flex-direction: column;
                    align-items: center;
                }
                
                .btn {
                    width: 100%;
                    text-align: center;
                }
                
                .hero h1 {
                    font-size: 2rem;
                }
            }
        </style>
    </head>
    <body class="antialiased">
        <!-- Navigation -->
        <nav class="nav-container">
            <div class="nav-content">
                <div class="logo">
                    <i class="fas fa-graduation-cap logo-icon"></i>
                    <span>Campus Digital</span>
                </div>
                
                <div class="nav-links">
                    <a href="#features" class="nav-link">Features</a>
                    <a href="#students" class="nav-link">For Students</a>
                    <a href="#teachers" class="nav-link">For Teachers</a>
                    <a href="#about" class="nav-link">About</a>
                </div>
                
                <div class="auth-buttons">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1>Transform Your Campus Experience with Digital Efficiency</h1>
                <p>A comprehensive platform designed to streamline academic operations for both <span class="highlight">students</span> and <span class="highlight">teachers</span>. Manage attendance, assignments, quizzes, and fees all in one place.</p>
                
                <div class="hero-buttons">
                    <a href="#students" class="btn btn-primary">I'm a Student</a>
                    <a href="#teachers" class="btn btn-secondary">I'm a Teacher</a>
                    <a href="#features" class="btn btn-secondary">Explore Features</a>
                </div>
            </div>
        </section>

        <!-- Features Overview -->
        <section class="section" id="features">
            <div class="section-title">
                <h2>Comprehensive Campus Management</h2>
                <p>All the tools you need for a seamless academic experience in one integrated platform</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon attendance">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3>Attendance Tracking</h3>
                    <p>Real-time attendance monitoring for students with automated reports and analytics for teachers.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon assignments">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h3>Assignment Management</h3>
                    <p>Upload, submit, and grade assignments digitally with deadline tracking and plagiarism checks.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon quizzes">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h3>Quiz & Examination</h3>
                    <p>Create, take, and automatically grade quizzes with instant feedback and performance analytics.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon fees">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h3>Fee Management</h3>
                    <p>View fee statements, payment history, and make secure online payments with receipt generation.</p>
                </div>
            </div>
        </section>

        <!-- Student Features -->
        <section class="section" id="students">
            <div class="section-title">
                <h2>Designed for Students</h2>
                <p>Everything you need to manage your academic journey efficiently</p>
            </div>
            
            <div class="roles-container">
                <div class="role-card student">
                    <div class="role-header">
                        <div class="role-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h3 class="role-title">Student Portal</h3>
                    </div>
                    
                    <p class="role-description">Access all your academic information and resources in one centralized dashboard.</p>
                    
                    <ul class="features-list">
                        <li><i class="fas fa-check-circle"></i> <strong>View Attendance:</strong> Track your attendance records in real-time with percentage calculations</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Submit Assignments:</strong> Upload assignments before deadlines with automatic confirmation</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Take Quizzes:</strong> Participate in online quizzes with instant results and feedback</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Fee Management:</strong> View fee statements, payment history, and make online payments</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Academic Calendar:</strong> Access important dates, deadlines, and schedule information</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Grade Tracking:</strong> Monitor your performance across all courses and assignments</li>
                    </ul>
                    
                    <div style="margin-top: 2rem; text-align: center;">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-primary">Sign Up as Student</a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Teacher Features -->
        <section class="section" id="teachers">
            <div class="section-title">
                <h2>Empowering Teachers</h2>
                <p>Tools to enhance teaching efficiency and student engagement</p>
            </div>
            
            <div class="roles-container">
                <div class="role-card teacher">
                    <div class="role-header">
                        <div class="role-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h3 class="role-title">Teacher Portal</h3>
                    </div>
                    
                    <p class="role-description">Manage your classes, track student progress, and streamline academic processes.</p>
                    
                    <ul class="features-list">
                        <li><i class="fas fa-check-circle"></i> <strong>Mark Attendance:</strong> Take attendance digitally with automated reports and analytics</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Create Assignments:</strong> Design and assign tasks with customizable deadlines and rubrics</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Grade Submissions:</strong> Review and grade student work with feedback and scoring</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Design Quizzes:</strong> Create quizzes with multiple question types and auto-grading</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Student Analytics:</strong> Track student performance and identify areas for improvement</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Communication Tools:</strong> Send announcements and notifications to your students</li>
                    </ul>
                    
                    <div style="margin-top: 2rem; text-align: center;">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-primary">Sign Up as Teacher</a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <h2>Ready to Transform Your Campus Experience?</h2>
            <p>Join hundreds of students and teachers who are already using Campus Digital to streamline their academic workflow.</p>
            
            <div class="cta-buttons">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-light">Go to Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-light">Get Started Free</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light">Login to Account</a>
                    @endif
                @endif
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer" id="about">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Campus Digital</h3>
                    <p>A comprehensive digital platform designed to modernize academic operations and enhance the learning experience for both students and educators.</p>
                    <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                        <a href="#" style="color: white; font-size: 1.2rem;"><i class="fab fa-twitter"></i></a>
                        <a href="#" style="color: white; font-size: 1.2rem;"><i class="fab fa-facebook"></i></a>
                        <a href="#" style="color: white; font-size: 1.2rem;"><i class="fab fa-linkedin"></i></a>
                        <a href="#" style="color: white; font-size: 1.2rem;"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#students">For Students</a></li>
                        <li><a href="#teachers">For Teachers</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-envelope" style="margin-right: 8px;"></i> support@campusdigital.app</li>
                        <li><i class="fas fa-phone" style="margin-right: 8px;"></i> +1 (555) 123-4567</li>
                        <li><i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i> 123 University Ave, Campus City</li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 Campus Digital. All rights reserved.</p>
            </div>
        </footer>

        <script>
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if(targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if(targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Add scroll effect to navbar
            window.addEventListener('scroll', function() {
                const nav = document.querySelector('.nav-container');
                if (window.scrollY > 50) {
                    nav.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
                } else {
                    nav.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
                }
            });
        </script>
    </body>
</html>