<?php 
require_once 'includes/config.php';

if (!$mysqli || $mysqli->connect_error) {
    die("❌ Нет соединения с БД");
}

$BITRIX_WEBHOOK = 'https://k7s.bitrix24.by/rest/25370/o4k69x5rthf0grzi/crm.lead.add.json';

$form_success = false;
$form_error = '';
$form_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));
    $form_type = htmlspecialchars(trim($_POST['form_type'] ?? 'Контактная форма'));
    
    $form_data = compact('name', 'phone', 'message', 'form_type');
    
    if (empty($name) || empty($phone)) {
        $form_error = 'Пожалуйста, заполните имя и телефон';
    } else {
        $leadData = [
            'fields' => [
                'TITLE' => 'Заявка с сайта Medikator.ru - ' . $form_type,
                'NAME' => $name,
                'PHONE' => [['VALUE' => $phone, 'VALUE_TYPE' => 'WORK']],
                'SOURCE_ID' => 'WEB',
                'SOURCE_DESCRIPTION' => $form_type . ' на сайте',
                'ASSIGNED_BY_ID' => 1,
                'STATUS_ID' => 'NEW',
                'COMMENTS' => "Форма: $form_type\nИмя: $name\nТелефон: $phone\nСообщение: $message\n\nДата: " . date('d.m.Y H:i:s'),
            ]
        ];
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $BITRIX_WEBHOOK,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($leadData),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ]
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $result = json_decode($response, true);
        
        file_put_contents('bitrix_log.txt', 
            date('Y-m-d H:i:s') . " | HTTP: $httpCode | Форма: $form_type\n" .
            "Ответ: " . print_r($result, true) . "\n\n",
            FILE_APPEND
        );
        
        if (isset($result['result'])) {
            $form_success = true;
            $form_data = [];
        } else {
            $form_error = 'Ошибка отправки. Пожалуйста, позвоните нам по телефону.';
        }
    }
}

$popular_products = [];
$sql = "SELECT m.*, 
               (SELECT path_img FROM medicator_img WHERE medicator_id = m.id AND is_Main = 1 LIMIT 1) as main_img,
               COALESCE(SUM(mv.view_count), 0) as total_views
        FROM medicator m 
        LEFT JOIN medicator_view mv ON m.id = mv.medicator_id
        GROUP BY m.id
        ORDER BY total_views DESC, m.id ASC
        LIMIT 3";
$result = $mysqli->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $popular_products[] = $row;
    }
}

// Если нет товаров с просмотрами, берем просто первые 3 товара
if (empty($popular_products)) {
    $sql = "SELECT m.*, 
                   (SELECT path_img FROM medicator_img WHERE medicator_id = m.id AND is_Main = 1 LIMIT 1) as main_img
            FROM medicator m 
            ORDER BY m.id 
            LIMIT 3";
    $result = $mysqli->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $popular_products[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>7company - Медикаторы-дозаторы для сельского хозяйства</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    <script src="js/script.js" defer></script>
    <style>
       
    </style>
</head>
<body>
    <?php require_once 'includes/header.php'; ?>

    <main class="main">
       
<!-- Hero секция -->
<section class="hero-products">
    <div class="container">
        <div class="hero-products__wrapper">
            <div class="hero-products__content">
                <h1 class="hero-products__title">
                    МЕДИКАТОРЫ <br>
                   <span class="gradient-text">ДЛЯ ХОЗЯЙСТВ</span>
                </h1>
                <p class="hero-products__text">
                    Точное дозирование препаратов и добавок в систему водоснабжения. 
                    <strong>Надёжные решения</strong> для птицеводства, свиноводства и животноводства.
                </p>
                <div class="hero-products__buttons">
                    <a href="#" class="btn btn-primary btn-order open-modal-form" data-form="hero">ОСТАВИТЬ ЗАЯВКУ</a>
                    <a href="catalog.php" class="btn btn-outline btn-catalog">Каталог продукции →</a>
                </div>
                <div class="hero-products__stats">
                    <div class="stat-item">
                        <span class="stat-value">10+</span>
                        <span class="stat-label">лет на рынке</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">500+</span>
                        <span class="stat-label">хозяйств</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">15</span>
                        <span class="stat-label">регионов</span>
                    </div>
                </div>
            </div>
            <div class="hero-products__image">
                <img src="products/medicator.png" alt="Медикаторы для хозяйств">
            </div>
        </div>
    </div>
</section>

        <section class="categories">
            <div class="container">
                <h2 class="section-title">ПОПУЛЯРНЫЕ <span class="gradient-text">КАТЕГОРИИ</span></h2>
                <p class="section-subtitle">Подберите медикатор-дозатор под задачи вашего хозяйства</p>
                
                <div class="categories__grid">
                    <div class="category-card category-card--gradient-1">
                        <h3 class="category-card__title">Медикаторы Master Pro</h3>
                        <p class="category-card__desc">Профессиональные медикаторы для крупных хозяйств с высокой производительностью</p>
                        <a href="catalog.php" class="category-card__link">Перейти в каталог →</a>
                    </div>

                    <div class="category-card category-card--gradient-2">
                        <h3 class="category-card__title">Медикаторы Dosatron</h3>
                        <p class="category-card__desc">Французские дозаторы с мировым именем — точность и надёжность</p>
                        <a href="catalog.php" class="category-card__link">Перейти в каталог →</a>
                    </div>

                    <div class="category-card category-card--gradient-3">
                        <h3 class="category-card__title">Медикаторы MixRite</h3>
                        <p class="category-card__desc">Израильские медикаторы для интенсивного животноводства и птицеводства</p>
                        <a href="catalog.php" class="category-card__link">Перейти в каталог →</a>
                    </div>
                </div>
            </div>
        </section>

<section class="advantages">
    <div class="container">
        <h1 class="section-title">ПОЧЕМУ ВЫБИРАЮТ <br> <span class="gradient-text">НАШИ ДОЗАТОРЫ</span></h1>
        
        <div class="advantages__grid">
            <div class="advantage-card">
                <div class="advantage-card__icon">🧪</div>
                <h3 class="advantage-card__title">Устойчивость к агрессивным средам</h3>
                <p class="advantage-card__desc">Корпус из химически стойких материалов выдерживает кислоты и щёлочи</p>
            </div>

            <div class="advantage-card">
                <div class="advantage-card__icon">💰</div>
                <h3 class="advantage-card__title">Экономия до 30%</h3>
                <p class="advantage-card__desc">Снижение расхода препаратов за счёт точного пропорционального дозирования</p>
            </div>

            <div class="advantage-card">
                <div class="advantage-card__icon">🔧</div>
                <h3 class="advantage-card__title">Простой монтаж</h3>
                <p class="advantage-card__desc">Установка на трубопровод за 30 минут без специального инструмента</p>
            </div>

            <div class="advantage-card">
                <div class="advantage-card__icon">✅</div>
                <h3 class="advantage-card__title">Гарантия 3 года</h3>
                <p class="advantage-card__desc">Полная гарантия на все компоненты и бесплатная замена деталей</p>
            </div>

            <div class="advantage-card">
                <div class="advantage-card__icon">👨‍💼</div>
                <h3 class="advantage-card__title">Персональный менеджер</h3>
                <p class="advantage-card__desc">Всегда на связи: подбор оборудования, консультации, техподдержка</p>
            </div>
            <div class="advantage-card">
                <div class="advantage-card__icon">🚀</div>
                <h3 class="advantage-card__title">Быстрая доставка</h3>
                <p class="advantage-card__desc">Доставка по всей России в кратчайшие сроки</p>
            </div>
        </div>
    </div>
</section>

<section class="how-we-work-steps">
    <div class="container">
        <h2 class="section-title">КАК МЫ РАБОТАЕМ — <span class="gradient-text">ПО ШАГАМ</span> </h2>
        
        <div class="steps-grid">
            <div class="step-item">
                <div class="step-icon">1</div>
                <h3 class="step-item__title">Оставляете заявку</h3>
                <p class="step-item__desc">Мы связываемся с вами в течение 15 минут</p>
            </div>

            <div class="step-item">
                <div class="step-icon">2</div>
                <h3 class="step-item__title">Уточняем детали</h3>
                <p class="step-item__desc">Обсуждаем товар, объём и требования к доставке</p>
            </div>

            <div class="step-item">
                <div class="step-icon">3</div>
                <h3 class="step-item__title">Высылаем КП с расчётами</h3>
                <p class="step-item__desc">Даём прозрачную смету: стоимость, сроки, варианты доставки</p>
            </div>

            <div class="step-item">
                <div class="step-icon">4</div>
                <h3 class="step-item__title">Заключаем договор</h3>
                <p class="step-item__desc">Фиксируем все условия и гарантии</p>
            </div>

            <div class="step-item">
                <div class="step-icon">5</div>
                <h3 class="step-item__title">Оказываем услугу</h3>
                <p class="step-item__desc">Закупаем, доставляем и при необходимости устанавливаем оборудование</p>
            </div>
        </div>
    </div>
</section>

<section class="calc-section">
    <div class="container">
        <div class="calc-card">
            <div class="calc-content">
             <h2 class="calc-title">
                РАССЧИТАЕМ СТОИМОСТЬ <br><span class="gradient-text">ПОД ВАШ ЗАПРОС</span>
            </h2>
                <p class="calc-text">
                    Оставьте заявку — подберём оптимальную модель медикатора для вашего хозяйства и рассчитаем коммерческое предложение.
                </p>
                
                <form class="calc-form-row" method="POST">
                    <input type="text" name="name" placeholder="Ваше имя" required>
                    <input type="tel" name="phone" placeholder="Ваш телефон" required>
                    <input type="hidden" name="form_type" value="Расчёт стоимости">
                    <button type="submit" class="calc-btn-row">ОСТАВИТЬ ЗАЯВКУ →</button>
                </form>
            </div>
        </div>
    </div>
</section>
     
<section class="products">
    <div class="container">
        <h2 class="section-title">ПОПУЛЯРНЫЕ <span class="gradient-text">ТОВАРЫ</span></h2>
        <div class="products__grid">
            <?php if (!empty($popular_products)): ?>
                <?php foreach ($popular_products as $product): ?>
                    <div class="product-card">
                        <?php if (!empty($product['total_views']) && $product['total_views'] > 0): ?>
                            <div class="popular-badge">🔥 Популярный</div>
                        <?php endif; ?>
                        <div class="product-card__image">
                            <img src="<?= htmlspecialchars($product['main_img'] ?? 'products/medikator.jpg') ?>" 
                                 alt="<?= htmlspecialchars($product['name']) ?>">
                        </div>
                        <div class="product-card__content">
                            <h3 class="product-card__title"><?= htmlspecialchars($product['name']) ?></h3>
                            <!-- ТУТ МЕНЯЕМ: Вместо opis выводим filtr -->
                            <p class="product-card__desc">
                                <?= htmlspecialchars($product['filtr'] ?? 'Серия медикатора') ?>
                            </p>
                            <div class="product-card__actions">
                                <button
                                    class="btn btn-secondary btn-compare"
                                    data-compare-id="<?= (int)$product['id'] ?>"
                                >
                                    В сравнение
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-secondary btn-cart"
                                    data-cart-add
                                    data-cart-id="<?= (int)$product['id'] ?>"
                                >
                                    В корзину
                                </button>
                                <a href="product.php?slug=<?= urlencode($product['slug']) ?>" class="btn btn-primary">Подробнее</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Заглушки -->
                <div class="product-card">
                    <div class="product-card__image">
                        <img src="products/medikator.jpg" alt="Медикатор Master Pro">
                    </div>
                    <div class="product-card__content">
                        <h3 class="product-card__title">Медикатор Master Pro 2000</h3>
                        <p class="product-card__desc">Master Pro</p>
                        <div class="product-card__actions">
                            <button class="btn btn-secondary btn-compare" type="button" disabled>В сравнение</button>
                            <a href="#" class="btn btn-primary">Подробнее</a>
                        </div>
                    </div>
                </div>
          
                <div class="product-card">
                    <div class="product-card__image">
                        <img src="products/medikator.jpg" alt="Медикатор Dosatron">
                    </div>
                    <div class="product-card__content">
                        <h3 class="product-card__title">Dosatron D25RE2</h3>
                        <p class="product-card__desc">Dosatron</p>
                        <div class="product-card__actions">
                            <button class="btn btn-secondary btn-compare" type="button" disabled>В сравнение</button>
                            <a href="#" class="btn btn-primary">Подробнее</a>
                        </div>
                    </div>
                </div>
        
                <div class="product-card">
                    <div class="product-card__image">
                        <img src="products/medikator.jpg" alt="Медикатор MixRite">
                    </div>
                    <div class="product-card__content">
                        <h3 class="product-card__title">MixRite TEFEN</h3>
                        <p class="product-card__desc">MixRite</p>
                        <div class="product-card__actions">
                            <button class="btn btn-secondary btn-compare" type="button" disabled>В сравнение</button>
                            <a href="#" class="btn btn-primary">Подробнее</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="text-center">
            <a href="catalog.php" class="btn btn-large">Весь каталог →</a>
        </div>
    </div>
</section>
 
      <section class="reviews">
    <div class="container">
        <h2 class="section-title">Отзывы наших клиентов</h2>
        
        <div class="swiper reviews-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="review-card">
                        <div class="review-rating">5,0 ★★★★★</div>
                        <p class="review-text">
                            Установили медикаторы Dosatron на 3 фермы. За полгода расход препаратов снизился на 20%. Отличная точность дозирования.
                        </p>
                        <div class="review-author">
                            <div class="review-name">Алексей Петров</div>
                            <div class="review-company">Агрохолдинг «Зелёная Долина»</div>
                        </div>
                    </div>
                </div>
                
                <div class="swiper-slide">
                    <div class="review-card">
                        <div class="review-rating">5,0 ★★★★★</div>
                        <p class="review-text">
                            Работаем с Master Pro уже 2 года. Надёжное оборудование, ни одной поломки. Техподдержка всегда на связи. Рекомендуем всем, кто ищет качественное решение для дозирования.
                        </p>
                        <div class="review-author">
                            <div class="review-name">Ирина Смирнова</div>
                            <div class="review-company">ООО «Птицефабрика Южная»</div>
                        </div>
                    </div>
                </div>
                
                <div class="swiper-slide">
                    <div class="review-card">
                        <div class="review-rating">5,0 ★★★★★</div>
                        <p class="review-text">
                            Заказывали MixRite для свиноводческого комплекса. Быстрая доставка, помогли с установкой. Рекомендую!
                        </p>
                        <div class="review-author">
                            <div class="review-name">Дмитрий Козлов</div>
                            <div class="review-company">КФХ Казань Д.А.</div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="review-card">
                        <div class="review-rating">5,0 ★★★★★</div>
                        <p class="review-text">
                            Отличное оборудование! Пользуемся уже год, нареканий нет. Дозаторы работают как часы.
                        </p>
                        <div class="review-author">
                            <div class="review-name">Сергей Иванов</div>
                            <div class="review-company">Агрофирма «Рассвет»</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
   
<!-- Секция "Свяжитесь с нами" -->
<section class="contact-section">
    <div class="container">
        <div class="contact-wrapper">
            <div class="contact-info">
                <h2 class="contact-title">СВЯЖИТЕСЬ<br>С НАМИ</h2>
                <p class="contact-text">
                    Оставьте заявку, и наш специалист свяжется с вами для консультации и подбора оборудования.
                </p>
                <ul class="contact-details">
                    <li>
                        <span class="contact-icon">📞</span>
                        <span>+7 (800) 123-45-67</span>
                    </li>
                    <li>
                        <span class="contact-icon">📧</span>
                        <span>info@medicator.ru</span>
                    </li>
                    <li>
                        <span class="contact-icon">📍</span>
                        <span>г. Москва, ул. Примерная, 1</span>
                    </li>
                </ul>
            </div>
            
            <div class="contact-form-card">
                <form class="contact-form" method="POST">
                    <div class="form-group">
                        <label>Ваше имя</label>
                        <input type="text" name="name" placeholder="Иван Иванов" required>
                    </div>
                    <div class="form-group">
                        <label>Телефон</label>
                        <input type="tel" name="phone" placeholder="+7 (___) ___-__-__" required>
                    </div>
                    <div class="form-group">
                        <label>Сообщение</label>
                        <textarea name="message" rows="4" placeholder="Опишите ваш запрос..."></textarea>
                    </div>
                    <input type="hidden" name="form_type" value="Свяжитесь с нами">
                    <button type="submit" class="contact-btn">ОТПРАВИТЬ ЗАЯВКУ</button>
                </form>
            </div>
        </div>
    </div>
</section>
</main>

<?php if ($form_success || !empty($form_error)): ?>
<div id="notification-modal" class="modal active">
    <div class="modal-content <?= $form_success ? 'success' : 'error' ?>">
        <span class="modal-close" onclick="this.parentElement.parentElement.classList.remove('active')">&times;</span>
        <div class="modal-icon"><?= $form_success ? '✅' : '❌' ?></div>
        <h3 class="modal-title"><?= $form_success ? 'Заявка отправлена!' : 'Ошибка!' ?></h3>
        <p class="modal-message">
            <?= $form_success ? 'Ваша заявка отправлена. Мы свяжемся с вами.' : htmlspecialchars($form_error) ?>
        </p>
        <button class="modal-btn" onclick="this.parentElement.parentElement.classList.remove('active')">Хорошо</button>
    </div>
</div>
<?php else: ?>
<div id="notification-modal" class="modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <div class="modal-icon">✅</div>
        <h3 class="modal-title">Успешно!</h3>
        <p class="modal-message">Ваша заявка отправлена. Мы свяжемся с вами.</p>
        <button class="modal-btn">Хорошо</button>
    </div>
</div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>


<script>
(function(w,d,u){
    var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
    var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
})(window,document,'https://cdn-ru.bitrix24.by/b15313854/crm/site_button/loader_2_el7etg.js');
</script>
    
</body>
</html>