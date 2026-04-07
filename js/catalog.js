// catalog.js
document.addEventListener('DOMContentLoaded', function() {
    // Фильтрация товаров
    const categoryBtns = document.querySelectorAll('.category-btn');
    const filterCheckboxes = document.querySelectorAll('.filter-submenu input[type="checkbox"]');
    const resetBtn = document.getElementById('reset-filters');
    const productsGrid = document.getElementById('products-grid');
    const productsCount = document.getElementById('products-count');
    
    let activeCategory = 'all';
    let activeSubcategories = new Set();
    
    // Функция обновления счетчика товаров
    function updateProductsCount() {
        const visibleProducts = document.querySelectorAll('.product-card:not(.hidden)');
        productsCount.textContent = `Найдено: ${visibleProducts.length} товаров`;
    }
    
    // Функция фильтрации товаров
    function filterProducts() {
        const products = document.querySelectorAll('.product-card');
        
        products.forEach(product => {
            const productCategory = product.dataset.category;
            const productSubcategory = product.dataset.subcategory;
            
            let categoryMatch = false;
            let subcategoryMatch = false;
            
            // Проверка основной категории
            if (activeCategory === 'all') {
                categoryMatch = true;
            } else {
                categoryMatch = (productCategory === activeCategory);
            }
            
            // Проверка подкатегорий
            if (activeSubcategories.size === 0) {
                subcategoryMatch = true;
            } else {
                subcategoryMatch = activeSubcategories.has(productSubcategory);
            }
            
            // Показываем товар, если совпадают оба условия
            if (categoryMatch && subcategoryMatch) {
                product.classList.remove('hidden');
            } else {
                product.classList.add('hidden');
            }
        });
        
        updateProductsCount();
    }
    
    // Обработчики для кнопок основных категорий
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Убираем активный класс у всех кнопок
            categoryBtns.forEach(b => b.classList.remove('active'));
            // Добавляем активный класс текущей кнопке
            this.classList.add('active');
            
            activeCategory = this.dataset.category;
            
            // Если выбрана категория, сбрасываем фильтры подкатегорий
            if (activeCategory !== 'all') {
                // Снимаем все галочки с чекбоксов
                filterCheckboxes.forEach(checkbox => {
                    if (checkbox.dataset.category !== activeCategory) {
                        checkbox.checked = false;
                    }
                });
                
                // Обновляем активные подкатегории
                activeSubcategories.clear();
                filterCheckboxes.forEach(checkbox => {
                    if (checkbox.checked && checkbox.dataset.category === activeCategory) {
                        activeSubcategories.add(checkbox.value);
                    }
                });
            }
            
            filterProducts();
        });
    });
    
    // Обработчики для чекбоксов подкатегорий
    filterCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const category = this.dataset.category;
            
            // Если выбрана конкретная категория, переключаем на нее
            if (activeCategory !== category && this.checked) {
                activeCategory = category;
                // Обновляем активный класс кнопок категорий
                categoryBtns.forEach(btn => {
                    if (btn.dataset.category === category) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                });
            }
            
            if (this.checked) {
                activeSubcategories.add(this.value);
            } else {
                activeSubcategories.delete(this.value);
            }
            
            filterProducts();
        });
    });
    
    // Сброс всех фильтров
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            // Сбрасываем основную категорию
            activeCategory = 'all';
            categoryBtns.forEach(btn => {
                if (btn.dataset.category === 'all') {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
            
            // Сбрасываем все чекбоксы
            filterCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Очищаем активные подкатегории
            activeSubcategories.clear();
            
            // Применяем фильтрацию
            filterProducts();
        });
    }
    
    // Dropdown меню для фильтров (мобильная версия)
    const dropdownBtns = document.querySelectorAll('.filter-dropdown');
    const filterSubmenus = document.querySelectorAll('.filter-submenu');

    function getSubmenuByFilterId(filterId) {
        for (const submenu of filterSubmenus) {
            if (submenu.dataset.submenu === filterId) {
                return submenu;
            }
        }
        return null;
    }
    
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const filterId = this.dataset.filter;
            const submenu = getSubmenuByFilterId(filterId);
            const filterGroup = this.closest('.filter-group');
            
            if (submenu && filterGroup) {
                filterGroup.classList.toggle('open');
                this.classList.toggle('active', filterGroup.classList.contains('open'));
                
                // Меняем стрелку
                const arrow = this.querySelector('.filter-arrow');
                if (arrow) {
                    arrow.textContent = filterGroup.classList.contains('open') ? '▲' : '▼';
                }
            }
        });
    });
    
    // Закрытие dropdown при клике вне
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.filter-group')) {
            dropdownBtns.forEach(btn => {
                const filterId = btn.dataset.filter;
                const submenu = getSubmenuByFilterId(filterId);
                const filterGroup = btn.closest('.filter-group');
                if (submenu && filterGroup && filterGroup.classList.contains('open')) {
                    filterGroup.classList.remove('open');
                    btn.classList.remove('active');
                    const arrow = btn.querySelector('.filter-arrow');
                    if (arrow) arrow.textContent = '▼';
                }
            });
        }
    });
    
    // Инициализация - показываем все товары
    filterProducts();
});