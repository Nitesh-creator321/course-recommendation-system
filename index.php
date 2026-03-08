<?php
session_start();

/* If the user is logged-in (session contains user_id) go straight to courses.php */
if (isset($_SESSION['user_id'])) {
    header("Location: courses.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intelligent Course Recommendation | Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #3b82f6;
            --secondary: #10b981;
            --dark-bg: #0f172a;
            --glass: rgba(15, 23, 42, 0.7);
            --card-glass: rgba(30, 41, 59, 0.5);
            --border: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* Fixed Navigation */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1.5rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(15px);
            z-index: 1000;
            border-bottom: 1px solid var(--border);
        }

        header h1 {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #fff;
            text-transform: uppercase;
        }

        .login-link {
            text-decoration: none;
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 8px 20px;
            border-radius: 8px;
            border: 1px solid var(--border);
            transition: 0.3s;
        }

        .login-link:hover {
            background: rgba(255,255,255,0.05);
            border-color: var(--primary);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(to bottom, rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.9)), 
                        url('images/inno.jpg') center/cover no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 20px;
            background-attachment: fixed;
        }

        .hero h1 {
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 800;
            max-width: 900px;
            margin-bottom: 20px;
            letter-spacing: -2px;
            background: linear-gradient(to bottom, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: slideUp 0.8s ease-out;
        }

        .hero p {
            font-size: 1.2rem;
            color: var(--text-dim);
            max-width: 700px;
            margin-bottom: 40px;
            animation: slideUp 1s ease-out;
        }

        .get-started-btn {
            padding: 18px 45px;
            background: var(--primary);
            color: white;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4);
            animation: slideUp 1.2s ease-out;
        }

        .get-started-btn:hover {
            transform: translateY(-5px);
            background: #2563eb;
            box-shadow: 0 20px 30px -10px rgba(59, 130, 246, 0.5);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* About Section */
        .section {
            padding: 100px 20px;
            max-width: 1200px;
            margin: auto;
        }

        .section h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 40px;
            text-align: center;
            letter-spacing: -1px;
        }

        .about-box {
            background: var(--card-glass);
            backdrop-filter: blur(10px);
            padding: 50px;
            border-radius: 24px;
            border: 1px solid var(--border);
            max-width: 1000px;
            margin: 0 auto 80px;
        }

        .about-box p {
            margin-bottom: 25px;
            color: var(--text-dim);
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .about-box strong { color: #fff; }

        /* Features Styling */
        .key-heading-box {
            display: block;
            margin: 0 auto 50px;
            padding: 10px 25px;
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary);
            border: 1px solid var(--primary);
            border-radius: 99px;
            width: fit-content;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 2px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .feature-card {
            background: var(--card-glass);
            padding: 40px 30px;
            border-radius: 20px;
            border: 1px solid var(--border);
            transition: 0.4s;
            text-align: left;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            background: rgba(30, 41, 59, 0.8);
            border-color: var(--primary);
        }

        .feature-card .icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 20px;
            display: block;
        }

        .feature-card h3 {
            font-size: 1.4rem;
            margin-bottom: 12px;
            color: #fff;
        }

        .feature-card p {
            font-size: 0.95rem;
            color: var(--text-dim);
        }

        /* Benefits Section */
        .benefits-section {
            background: #020617;
            padding: 120px 20px;
            border-radius: 60px 60px 0 0;
            margin-top: 50px;
        }

        .benefits-points {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 60px auto 0;
        }

        .benefit-card {
            padding: 30px;
            border-radius: 20px;
            background: rgba(255,255,255,0.02);
            border: 1px solid var(--border);
            transition: 0.3s;
        }

        .benefit-card:hover {
            border-color: var(--secondary);
            background: rgba(16, 185, 129, 0.05);
        }

        .benefit-card .icon {
            font-size: 2rem;
            color: var(--secondary);
            margin-bottom: 15px;
        }

        .benefit-card h3 {
            font-size: 1.2rem;
            color: #fff;
            margin-bottom: 10px;
        }

        /* Footer */
        footer {
            padding: 60px 20px;
            text-align: center;
            background: #020617;
            border-top: 1px solid var(--border);
            color: var(--text-dim);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            header { padding: 1rem 1.5rem; }
            .hero h1 { font-size: 2.2rem; }
            .about-box { padding: 30px; }
            .section { padding: 60px 20px; }
        }
    </style>
</head>
<body>

    <header>
        <h1>Intelligent Course Recommendation System</h1>
        <a href="login.php" class="login-link">Sign In</a>
    </header>

    <div class="hero">
        <h1>Unlock Your Potential with Personalized Learning</h1>
        <p>Our system intelligently connects you with the perfect courses, tailored to your interests and academic journey.</p>
        <a href="login.php" class="get-started-btn">Start Your Journey Now!</a>
    </div>

    <div class="section">
        <h2>About This Project</h2>
        <div class="about-box">
            <p>
                The <strong>Intelligent Course Recommendation System</strong> is a robust platform designed to revolutionize how students discover and enroll in courses. Leveraging the power of a sophisticated Database Management System (DBMS), it offers highly personalized course suggestions.
            </p>
            <p>
                Our core strength lies in efficiently managing vast amounts of data, including user profiles, course catalogs, and historical interactions. This allows us to deliver recommendations that are not just relevant, but truly transformative for your academic and professional growth. Built with a blend of <strong>PHP</strong>, <strong>MySQL</strong>, <strong>HTML</strong>, and <strong>CSS</strong>, the system ensures a seamless, dynamic, and intuitive user experience.
            </p>
            <p>
                Whether you're a high school graduate, a diploma holder, an undergraduate, or a postgraduate student, our system is engineered to simplify your course selection, making your educational journey smarter and more informed.
            </p>
        </div>

        <div class="key-heading-box">Key Capabilities</div>
        <div class="features">
            <div class="feature-card">
                <span class="icon"><i class="fas fa-brain"></i></span>
                <h3>Intelligent Matching</h3>
                <p>Advanced algorithms to connect you with the most relevant courses based on your unique profile.</p>
            </div>
            <div class="feature-card">
                <span class="icon"><i class="fas fa-filter"></i></span>
                <h3>Personalized Filters</h3>
                <p>Narrow down thousands of choices by your specific interests and current academic level.</p>
            </div>
            <div class="feature-card">
                <span class="icon"><i class="fas fa-shield-alt"></i></span>
                <h3>Secure Authentication</h3>
                <p>Robust user encryption and registration protocols to keep your educational data safe.</p>
            </div>
            <div class="feature-card">
                <span class="icon"><i class="fas fa-laptop-code"></i></span>
                <h3>Diverse Catalog</h3>
                <p>Access a massive repository of courses covering everything from AI to Project Management.</p>
            </div>
            <div class="feature-card">
                <span class="icon"><i class="fas fa-mobile-alt"></i></span>
                <h3>Adaptive UI</h3>
                <p>A seamless experience whether you are browsing on a desktop, tablet, or smartphone.</p>
            </div>
        </div>
    </div>

    <div class="benefits-section">
        <div style="max-width: 1200px; margin: auto; text-align: center;">
            <h2 style="color: white;">What Our System Offers You</h2>
            <p style="color: var(--text-dim); max-width: 700px; margin: 0 auto 40px;">Experience a tailored learning journey designed to empower your academic and career goals.</p>
            
            <div class="benefits-points">
                <div class="benefit-card">
                    <div class="icon"><i class="fas fa-magic"></i></div>
                    <h3>Effortless Discovery</h3>
                    <p>Find courses that genuinely match your interests and aspirations with ease.</p>
                </div>
                <div class="benefit-card">
                    <div class="icon"><i class="fas fa-user-check"></i></div>
                    <h3>Tailored Suggestions</h3>
                    <p>Receive personalized course recommendations based on your unique profile and goals.</p>
                </div>
                <div class="benefit-card">
                    <div class="icon"><i class="fas fa-graduation-cap"></i></div>
                    <h3>Academic Growth</h3>
                    <p>Unlock new opportunities and expand your knowledge with relevant learning paths.</p>
                </div>
                <div class="benefit-card">
                    <div class="icon"><i class="fas fa-lightbulb"></i></div>
                    <h3>Informed Decisions</h3>
                    <p>Make confident choices about your education with clear and concise course insights.</p>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 Intelligent Course Recommendation System. All rights reserved.</p>
        <p style="margin-top: 10px; font-size: 0.8rem; color: #475569;">Developed by Nitesh</p>
    </footer>

</body>
</html>