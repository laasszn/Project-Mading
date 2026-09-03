
document.addEventListener('contextmenu', e => e.preventDefault());

document.onkeydown = function(e) {
    
    if (event.keyCode == 123) return false;
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) return false;
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) return false;
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) return false;
    if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) return false;
}


document.addEventListener('contextmenu', e => e.preventDefault());
document.onkeydown = function(e) {
    if(event.keyCode == 123) return false;
    if(e.ctrlKey && (e.key === 'u' || e.key === 'i' || e.key === 'j' || e.key === 'c')) return false;
}


document.addEventListener("DOMContentLoaded", () => {
    
    
    setTimeout(() => {
        document.body.classList.add('loaded');
    }, 50);

    
    const links = document.querySelectorAll('a');
    
    links.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            
            
            if (!href || href.startsWith('#') || link.target === '_blank' || href.startsWith('javascript')) return;

            e.preventDefault();

            
            document.body.classList.remove('loaded');
            document.body.classList.add('fade-out');

            
            setTimeout(() => {
                window.location.href = href;
            }, 300);
        });
    });
});


function toggleMenu() {
    document.getElementById('navLinks').classList.toggle('active');
}


let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');

if(slides.length > 0) {
    function showSlide(index) {
        
        slides[currentSlide].classList.remove('active');
        dots[currentSlide].classList.remove('active');
        
        
        currentSlide = (index + slides.length) % slides.length;
        
        
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }
    setInterval(() => showSlide(currentSlide + 1), 4000);
}

