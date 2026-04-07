document.addEventListener('DOMContentLoaded', function() {
    // ===== Галерея =====
    const slides = document.querySelectorAll('.gallery-slide');
    const thumbs = document.querySelectorAll('.thumb');
    const prevBtn = document.getElementById('galleryPrev');
    const nextBtn = document.getElementById('galleryNext');
    
    let currentIndex = 0;
    const totalSlides = slides.length;
    
    function showSlide(index) {
        if (index < 0) index = 0;
        if (index >= totalSlides) index = totalSlides - 1;
        
        currentIndex = index;
        
        slides.forEach(slide => {
            slide.style.display = 'none';
        });
        
        if (slides[currentIndex]) {
            slides[currentIndex].style.display = 'flex';
        }
        
        thumbs.forEach((thumb, i) => {
            if (i === currentIndex) {
                thumb.classList.add('active');
                thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            } else {
                thumb.classList.remove('active');
            }
        });
    }
    
    if (thumbs.length > 0) {
        thumbs.forEach((thumb, index) => {
            thumb.addEventListener('click', () => {
                showSlide(index);
            });
        });
    }
    
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            showSlide(currentIndex - 1);
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            showSlide(currentIndex + 1);
        });
    }
    
    // Свайп для мобильных
    let touchStartX = 0;
    let touchEndX = 0;
    const galleryMain = document.querySelector('.gallery-main');
    
    if (galleryMain) {
        galleryMain.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        galleryMain.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            const diff = touchEndX - touchStartX;
            if (Math.abs(diff) > 50) {
                if (diff > 0) {
                    showSlide(currentIndex - 1);
                } else {
                    showSlide(currentIndex + 1);
                }
            }
        });
    }
    
    // Показываем первый слайд
    if (slides.length > 0) {
        showSlide(0);
    }
    
    // ===== Табы =====
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const tabId = btn.dataset.tab;
            
            tabBtns.forEach(b => b.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));
            
            btn.classList.add('active');
            const activePane = document.getElementById(`tab-${tabId}`);
            if (activePane) {
                activePane.classList.add('active');
            }
        });
    });
});