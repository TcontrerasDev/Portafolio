const { animate, scroll, spring, stagger, inView } = Motion;

// Detectar si es mobile
const isMobile = window.innerWidth < 768;

// Cursor Follower
const cursorFollower = document.getElementById('cursor-follower');
if (cursorFollower) {
    let isVisible = false;
    document.addEventListener('mousemove', (e) => {
        if (window.innerWidth < 1200) {
            if (isVisible) {
                animate(cursorFollower, { opacity: 0 }, { duration: 0.2 });
                isVisible = false;
            }
            return;
        }
        const { clientX, clientY } = e;
        if (!isVisible) {
            animate(cursorFollower, { x: clientX, y: clientY, opacity: 1 }, { duration: 0 });
            isVisible = true;
        } else {
            animate(cursorFollower, { x: clientX, y: clientY }, { duration: 0.08, easing: "ease-out" });
        }
    });
}

// --- Animaciones del Hero ---
const titleHero = document.querySelector('.title-hero');
if (titleHero) {
    animate(
        titleHero,
        { opacity: [0, 1], y: isMobile ? [10, 0] : [30, 0] },
        { duration: 0.8, easing: "ease-out", delay: 0.2 }
    );
}

// Typewriter Ultra-Estable (Sin Layout Shift)
function createTypewriter(element, startDelay) {
    if (!element) return;
    
    const text = element.textContent.trim();
    // Guardamos el alto actual para que el contenedor NO colapse
    const height = element.offsetHeight;
    if (!isMobile) element.style.minHeight = `${height}px`;

    element.innerHTML = ''; // Limpiamos
    
    const letters = text.split('').map(letter => {
        const span = document.createElement('span');
        span.textContent = letter === ' ' ? '\u00A0' : letter;
        span.style.opacity = '0';
        span.style.display = 'inline-block'; // Mejor control de transformaciones
        element.appendChild(span);
        return span;
    });

    animate(
        letters,
        { opacity: 1, y: isMobile ? [2, 0] : [5, 0] },
        { 
            duration: 0.05, 
            delay: stagger(0.03, { start: startDelay }) 
        }
    );
}

// Ejecutar typewriter solo si el elemento existe
const textHero = document.querySelector('.text-hero');
if (textHero) createTypewriter(textHero, 0.4);

const syncText = document.querySelector('.bottom-card p');
if (syncText) createTypewriter(syncText, 1.2);

// --- Animaciones de Scroll (inView) optimizadas ---

const stopSkills = inView(".technical .mt-5", () => {
    const skillCards = document.querySelectorAll(".skill-card");
    animate(
        skillCards,
        { opacity: [0, 1], y: isMobile ? [20, 0] : [50, 0] },
        { duration: 0.5, delay: stagger(0.08), easing: "ease-out" }
    );
    return stopSkills; // Motion lo usa para limpiar
}, { margin: "0px 0px -50px 0px" });

const stopExp = inView(".row-articles", () => {
    const expCards = document.querySelectorAll(".card-experiencia");
    expCards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('in-view');
            animate(
                card,
                { opacity: [0, 1], x: isMobile ? [0, 0] : [-20, 0], y: isMobile ? [20, 0] : [0, 0] },
                { duration: 0.5, easing: "ease-out" }
            );
        }, index * (isMobile ? 150 : 300));
    });
    return stopExp;
}, { margin: "0px 0px -50px 0px" });
