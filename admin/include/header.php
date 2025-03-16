
    <header class="header" id="header" role="banner">
        <h1 class="logo"><a href="#home" class="logo">Mohamed <span>FETTIS</span></a></h1>
        <h2 class="logo-mobile"><a href="#home" class="logo-mobile">M <span>F</span></a></h2>

        <i class="bx bx-menu" id="menu-icon"></i>
        <nav class="navbar" aria-label="Main navigation">
            <a href="../../index.php">Home</a>
            <a href="#about">About</a>
            <a href="#services">Services</a>
            <a href="#projects">Projects</a>
            <a href="./cv/cv.html">Curriculum Vitae</a>
        </nav>
        <a class="gradient-btn" href="#contact">Contact Me</a>
    <script> 
        let lastScrollY = window.scrollY;
        const header = document.getElementById('header');

        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;
            if (currentScrollY > lastScrollY && currentScrollY > 50) {
                header.style.transform = 'translateY(-100%)';
            } else {
                header.style.transform = 'translateY(0)';
            }
            lastScrollY = currentScrollY;
        });
    </script>
    </header>