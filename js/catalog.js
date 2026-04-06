// Фильтрация товаров
let currentCategory = 'all';
let activeSubcategories = {
    masterpro: [],
    dosatron: [],
    mixrite: []
};

// Получить все товары
function getAllProducts() {
    return document.querySelectorAll('.product-card');
}

// Обновить счетчик товаров
function updateCount() {
    const visibleProducts = document.querySelectorAll('.product-card:not(.hidden)');
    const countSpan = document.getElementById('products-count');
    if (countSpan) {
        countSpan.textContent = `Найдено: ${visibleProducts.length} товаров`;
    }
}

// Применить фильтры
function applyFilters() {
    const products = getAllProducts();
    
    products.forEach(product => {
        let show = true;
        const productCategory = product.dataset.category;
        const productSubcategory = product.dataset.subcategory;
        
        // Фильтр по основной категории
        if (currentCategory !== 'all' && productCategory !== currentCategory) {
            show = false;
        }
        
        // Фильтр по подкатегориям
        if (show && activeSubcategories[productCategory] && activeSubcategories[productCategory].length > 0) {
            if (!activeSubcategories[productCategory].includes(productSubcategory)) {
                show = false;
            }
        }
        
        if (show) {
            product.classList.remove('hidden');
        } else {
            product.classList.add('hidden');
        }
    });
    
    updateCount();
}

// Инициализация дропдаунов
document.querySelectorAll('.filter-dropdown').forEach(btn => {
    btn.addEventListener('click', () => {
        const group = btn.closest('.filter-group');
        group.classList.toggle('open');
    });
});

// Обработка чекбоксов
document.querySelectorAll('.filter-submenu input').forEach(checkbox => {
    checkbox.addEventListener('change', (e) => {
        const value = e.target.value;
        const category = e.target.dataset.category;
        
        if (e.target.checked) {
            if (!activeSubcategories[category].includes(value)) {
                activeSubcategories[category].push(value);
            }
        } else {
            activeSubcategories[category] = activeSubcategories[category].filter(v => v !== value);
        }
        
        applyFilters();
    });
});

// Обработка категорий
document.querySelectorAll('.category-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        currentCategory = btn.dataset.category;
        applyFilters();
    });
});

// Сброс фильтров
const resetBtn = document.getElementById('reset-filters');
if (resetBtn) {
    resetBtn.addEventListener('click', () => {
        currentCategory = 'all';
        activeSubcategories = {
            masterpro: [],
            dosatron: [],
            mixrite: []
        };
        
        // Сброс активного класса категорий
        document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
        document.querySelector('.category-btn[data-category="all"]').classList.add('active');
        
        // Сброс чекбоксов
        document.querySelectorAll('.filter-submenu input').forEach(cb => cb.checked = false);
        
        applyFilters();
    });
}

// Добавляем CSS класс hidden
const style = document.createElement('style');
style.textContent = '.product-card.hidden { display: none; }';
document.head.appendChild(style);

// Инициализация
applyFilters();