<!DOCTYPE html>
<html lang="en">
<head>
    <!-- google fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    <!-- Meta tags inchangés -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="React JS developer specializing in responsive websites and frontend projects. Explore Mohamed Fettis' portfolio for web development solutions.">
    <meta name="author" content="Mohamed Amokrane Fettis">
    <meta name="keywords" content="web developer, React JS, portfolio, HTML, CSS, JavaScript, Figma, UI/UX design, frontend development">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Styles -->
    <link rel="stylesheet" href="/portfolio/assets/css/style.css">


    <!-- Boxicons -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons/css/boxicons.min.css">
     

    <!-- Favicons -->
    <link rel="shortcut icon" href="./imgs/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="./imgs/favicon.ico">
    
    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://fettis.ct.ws/">
    <meta property="og:title" content="Mohamed Amokrane Fettis - Web Developer">
    <meta property="og:description" content="Portfolio of a professional web developer specializing in React JS and modern web integration.">
    <meta property="og:image" content="https://fettis.ct.ws/imgs/og-image.jpg">
    <meta property="og:image:alt" content="Mohamed Fettis developer portfolio preview">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Mohamed Amokrane Fettis - JS Developer">
    <meta name="twitter:description" content="Web developer portfolio showcasing React JS projects and frontend expertise.">
    <meta name="twitter:creator" content="@moha98fts">
    <meta name="twitter:image" content="https://fettis.ct.ws/imgs/og-image.jpg">

    <!-- Preconnects -->
    <link rel="preconnect" href="https://www.googletagmanager.com">
    <link rel="preconnect" href="https://unpkg.com">
    <title>Mohamed Fettis - React Developer | Portfolio</title>
</head>
<body>
<?php include 'assets/include/header.php'; ?>

    <main class="container" id="main-content" role="main">
        <section class="home" id="home">
            <div class="home-content">
                <h2>Hi, It's <span>Fettis</span></h2>
                <h3>I'm <span>Web Developer</span></h3>
                <p>I am a graduate of a professional degree in Web Integration and Design I specialize in creating responsive, user-friendly websites using HTML, CSS, JavaScript, and design tools like Figma. My goal is to deliver high-quality web solutions that combine functionality with aesthetics.</p>
                <div class="social-icons">
                    <a href="https://github.com/mohamedfettis" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
                        <i class='bx bxl-github'></i>
                    </a>
                    <a href="https://www.linkedin.com/in/mohamed-amokrane-fettis-12299729b/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                        <i class='bx bxl-linkedin-square'></i>
                    </a>
                    <a href="https://x.com/moha98fts" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                        <i class='bx bxs-x-square'></i>
                    </a>
                </div>
                <div class="btn-group">
                    <a href="#about" class="btn">Hire</a>
                    <a href="#contact" class="btn">Contact</a>
                </div>
            </div>
            <div class="home-img">
                <img src="./assets/imgs/d4af37.png" 
                     alt="Mohamed Fettis - Développeur Web" 
                     loading="lazy" 
                     width="600">
            </div>
        </section>

        <section class="about" id="about">
            <div class="about-img">
                <i class='bx bxs-user-check'></i>
            </div>
            <div class="about-content">
                <h2>About <span>Me</span></h2>
                <p>
                    Hello, my name is Mohamed Amokrane Fettis, and I am a graduate of a professional degree in Web Integration and Design.
                    I specialize in creating responsive, user-friendly websites using HTML, CSS, JavaScript, and design tools like Figma. My goal is to deliver high-quality web solutions that combine functionality with aesthetics.
                    Feel free to explore my portfolio to see my work and achievements!
                </p>
                <a href="#" class="btn">Read More</a>
            </div>
        </section>

       

        <section class="services" id="services">
            <h2 class="heading">My <span>Services</span></h2>
            <div class="services-container">
                <div class="service-box">
                    <div class="service-info">
                        <i class='bx bxl-figma'></i>
                        <h3>UI/UX Design</h3>
                        <p>Professional interface design with Figma, creating intuitive user experiences and modern visual designs for web and mobile applications.</p>
                    </div>
                </div>

                <div class="service-box">
                    <div class="service-info">
                        <i class='bx bx-code-alt'></i>
                        <h3>Frontend Development</h3>
                        <p>Development of responsive websites with HTML5, CSS3 and JavaScript ES6+, integration of React JS components and performance optimization.</p>
                    </div>
                </div>

                <div class="service-box">
                    <div class="service-info">
                        <i class='bx bxl-python'></i>
                        <h3>Task Automation</h3>
                        <p>Automation of repetitive tasks and processes using Python scripts, Selenium and BeautifulSoup for increased productivity.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="projects" id="projects">
            <h2 class="heading">My <span>Projects</span></h2>
            <div class="project-box">
                <div class="design-project">
                    <a href="./assets/include/design.php">
                        <i class='bx bx-paint'></i>
                        <h3 style="color: #d4af37;">Design </h3>
                    </a>
                </div>
                <div class="dev-projects">
                    <a href="./assets/include/development.php">
                        <i class='bx bx-code-curly'></i>
                        <h3 style="color: #d4af37;">Development </h3>
                    </a>
                </div>


               
            </div>
        </section>

        <section class="contact" id="contact">
            <h2 class="heading">Contact <span>Me</span></h2>
            <p class="sub-heading">Have a question or want to <span>work together <i class='bx bxs-briefcase-alt-2'></i></span></p>

            <form class="form" action="https://getform.io/f/bdrrnpgb" method="POST">
                <input type="text" id="name" name="name" placeholder="Full Name" required>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <input type="text" id="subject" name="subject" placeholder="Subject" required>
                <textarea id="message" name="message" rows="10" placeholder="Your Message" required></textarea>
                <button type="submit" class="btn">Send Message</button>
            </form>
        </section>

    </main>

    <?php include './assets/include/footer.php'; ?>

    <!-- Scripts -->
    <script src="./assets/js/script.js"></script>
    
    <!-- Microdata -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Person",
        "name": "Mohamed Amokrane Fettis",
        "jobTitle": "Fullstack Web Developer",
        "alumniOf": {
            "@type": "EducationalOrganization",
            "name": "Web Development Training Institute"
        },
        "url": "https://fettis.ct.ws/",
        "sameAs": [
            "https://github.com/mohamedfettis",
            "https://www.linkedin.com/in/mohamed-amokrane-fettis-12299729b/"
        ],
        "image": "https://fettis.ct.ws/imgs/og-image.jpg",
        "description": "Web developer specializing in React JS and modern web integration",
        "email": "moh.fts98@gmail.com",
        "address": {
            "@type": "rue michel goudechoux sannois 95110",
            "addressLocality": "Paris",
            "addressCountry": "FR"
        }
    }
    </script>

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4EXGZ6DQJ3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-4EXGZ6DQJ3');
    </script>
    <script>
        // get date year
        const date = new Date();
        const year = date.getFullYear();
        document.getElementById('copyright-year').textContent = year;
    </script>
</body>
</html>