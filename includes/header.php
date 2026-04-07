 <!-- <header class="header">
    <div class="container">
        <div class="header__inner">
            <button class="burger-btn" id="burgerBtn" aria-label="Открыть меню" aria-expanded="false" aria-controls="mainNav">
                <span class="burger-btn__line"></span>
                <span class="burger-btn__line"></span>
                <span class="burger-btn__line"></span>
            </button>

            <a href="index.php" class="logo">
                <div class="logo__img">
                    <img src="logo.jpg" alt="7company" width="40" height="40" loading="lazy">
                </div>
                <span class="logo__text">7 company</span>
            </a>

   

            <div class="nav-overlay" id="navOverlay"></div>

            <nav class="nav" id="mainNav" aria-label="Основная навигация">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="index.php" class="nav__link nav__link--active">Главная</a>
                    </li>
                    <li class="nav__item has-dropdown">
                        <a href="catalog.php" class="catalog-link" id="catalogLink">
                            Каталог
                        </a>
                        <ul class="dropdown-menu" id="catalogDropdown">
                            <li><a href="catalog.php">Все модели</a></li>
                            <li><a href="catalog.php">DIA</a></li>
                            <li><a href="catalog.php">D07</a></li>
                        </ul>
                    </li>
                    <li class="nav__item">
                        <a href="contacts.php" class="nav__link">Контакты</a>
                    </li>
                    <li class="nav__item">
                        <a href="compare.php" class="nav__link">Сравнение</a>
                    </li>
                    <li class="nav__item nav__item--search">
                        <div class="sidebar-search">
                            <div class="search-box">
                                <input type="text" id="searchInput" placeholder="Поиск по названию...">
                                <button id="searchBtn" type="button">🔍</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
                     <a href="contacts.php#contactFormSplit" class="btn btn-primary header__order-btn">Заказать</a>
        </div>
    </div>
</header> -->
 <header class="header">
        <div class="container">
            <div class="header__inner">
                <a href="index.php" class="logo">
                    
                    <span class="logo__text">7 company</span>
                </a>

                <nav class="nav">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="index.php" class="nav__link ">Главная</a>
                        </li>
                        <li>
                            <a href="catalog.php" class="nav__link">Каталог</a>
                        </li>
                        <li class="nav__item">
                            <a href="contacts.php" class="nav__link">Контакты</a>
                        </li>
                        <li class="nav__item">
                            <a href="compare.php" class="nav__link">
                                Сравнение (<span data-compare-count>0</span>)
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="cart.php" class="nav__link">
                                Корзина (<span data-cart-count>0</span>)
                            </a>
                        </li>
                    </ul>
                </nav>

                <button type="button" class="btn btn-primary header-lead-open" data-lead-open>
                    Оставить заявку
                </button>
            </div>
        </div>
    </header>

    <div class="header-lead-modal" id="headerLeadModal" aria-hidden="true">
        <div class="header-lead-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="headerLeadTitle">
            <button type="button" class="header-lead-modal__close" data-lead-close aria-label="Закрыть форму">&times;</button>
            <h3 class="header-lead-modal__title" id="headerLeadTitle">Оставить заявку</h3>
            <p class="header-lead-modal__subtitle">Оставьте контакты, и мы свяжемся с вами.</p>

            <form id="headerLeadForm" class="header-lead-form">
                <input type="text" name="name" placeholder="Ваше имя" required>
                <input type="tel" name="phone" placeholder="Ваш телефон" required>
                <textarea name="message" rows="4" placeholder="Сообщение (необязательно)"></textarea>
                <input type="hidden" name="form_type" value="Модальная форма в хедере">
                <button type="submit" class="btn btn-primary header-lead-form__submit">Отправить</button>
            </form>

            <p id="headerLeadStatus" class="header-lead-form__status" aria-live="polite"></p>
        </div>
    </div>

    <script>
    (function () {
        var modal = document.getElementById('headerLeadModal');
        var openBtn = document.querySelector('[data-lead-open]');
        var closeBtn = document.querySelector('[data-lead-close]');
        var form = document.getElementById('headerLeadForm');
        var status = document.getElementById('headerLeadStatus');

        if (!modal || !openBtn || !closeBtn || !form || !status) {
            return;
        }

        function openModal() {
            modal.classList.add('is-active');
            modal.setAttribute('aria-hidden', 'false');
        }

        function closeModal() {
            modal.classList.remove('is-active');
            modal.setAttribute('aria-hidden', 'true');
        }

        function setStatus(message, isError) {
            status.textContent = message;
            status.classList.toggle('is-error', !!isError);
            status.classList.toggle('is-success', !isError);
        }

        openBtn.addEventListener('click', openModal);
        closeBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && modal.classList.contains('is-active')) {
                closeModal();
            }
        });

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            setStatus('Отправляем заявку...', false);

            var submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;

            fetch('includes/bitrix_form.php', {
                method: 'POST',
                body: new FormData(form)
            })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                if (data && data.success) {
                    setStatus(data.message || 'Заявка отправлена! Мы свяжемся с вами.', false);
                    form.reset();
                    setTimeout(closeModal, 1200);
                } else {
                    setStatus((data && data.message) || 'Ошибка отправки. Попробуйте позже.', true);
                }
            })
            .catch(function () {
                setStatus('Ошибка сети. Проверьте подключение и попробуйте снова.', true);
            })
            .finally(function () {
                submitBtn.disabled = false;
            });
        });
    })();
    </script>
    <script src="js/compare-storage.js" defer></script>
    <script src="js/cart-storage.js" defer></script>