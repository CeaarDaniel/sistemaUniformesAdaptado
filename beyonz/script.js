
        // Animación al hacer scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.animate-on-scroll');
            elements.forEach(element => {
                const position = element.getBoundingClientRect();
                if(position.top < window.innerHeight * 0.85) {
                    element.classList.add('visible');
                }
            });
        }
        
        // Inicializar animaciones
        window.addEventListener('load', animateOnScroll);
        window.addEventListener('scroll', animateOnScroll);
        
        // Cambiar navbar al hacer scroll
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if(window.scrollY > 100) {
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
                document.querySelector('.navbar-brand img').style.height = '45px';
            } else {
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = '0 2px 15px rgba(0, 0, 0, 0.1)';
                document.querySelector('.navbar-brand img').style.height = '50px';
            }
        });
        
        // Función para cambiar idioma (simulada)
        function cambiarIdioma() {
            alert('Cambiando a versión en inglés...');
            // Aquí iría la lógica real para cambiar el idioma
        }