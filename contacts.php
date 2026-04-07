<?php
$BITRIX_WEBHOOK = 'https://k7s.bitrix24.by/rest/25370/o4k69x5rthf0grzi/crm.lead.add.json';

$form_success = false;
$form_error = '';
$form_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));
    
    $form_data = compact('name',  'phone', 'message');
    
    if (empty($name) || empty($phone)) {
        $form_error = 'Пожалуйста, заполните имя и телефон';
    } else {
        $leadData = [
            'fields' => [
                'TITLE' => 'Заявка с сайта Medikator.ru',
                'NAME' => $name,
                'PHONE' => [['VALUE' => $phone, 'VALUE_TYPE' => 'WORK']],
                'SOURCE_ID' => 'WEB',
                'SOURCE_DESCRIPTION' => 'Контактная форма сайта',
                'ASSIGNED_BY_ID' => 1,
                'STATUS_ID' => 'NEW',
                'COMMENTS' => "Имя: $name\nТелефон: $phone\nСообщение: $message\n\nДата: " . date('d.m.Y H:i:s'),
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
            date('Y-m-d H:i:s') . " | HTTP: $httpCode\n" .
            "Ответ: " . print_r($result, true) . "\n\n",
            FILE_APPEND
        );
        
        if (isset($result['result'])) {
            $form_success = true;
            $form_data = [];
        } else {
            $form_error = 'Ошибка отправки. Пожалуйста, позвоните нам.';
        }
    }
}


?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>7company - Контакты</title>
    <link rel="stylesheet" href="css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/contacts.css?v=<?= time() ?>">
</head>
<body>
   <?php  require_once 'includes/header.php';?>

    <main class="main">
        <!-- Контактная информация -->
        <section class="contacts-info-section">
            <div class="container">
                <div class="contacts-info-card">
                    <h1 class="contacts-info-title">КОНТАКТЫ</h1>
                    <p class="contacts-info-subtitle">Свяжитесь с нами любым удобным способом — мы всегда на связи</p>
                    
                    <div class="contacts-info-list">
                        <div class="contacts-info-item">
                            <div class="contacts-info-item__title">Телефон</div>
                            <div class="contacts-info-item__value">+7 (800) 123-45-67</div>
                            <div class="contacts-info-item__desc">Бесплатно по России</div>
                        </div>
                        
                        <div class="contacts-info-item">
                            <div class="contacts-info-item__title">E-mail</div>
                            <div class="contacts-info-item__value">info@medicator.ru</div>
                            <div class="contacts-info-item__desc">Ответим в течение часа</div>
                        </div>
                        
                        <div class="contacts-info-item">
                            <div class="contacts-info-item__title">Адрес</div>
                            <div class="contacts-info-item__value">г. Москва, ул. Примерная, 1</div>
                            <div class="contacts-info-item__desc">Офис и склад</div>
                        </div>
                        
                        <div class="contacts-info-item">
                            <div class="contacts-info-item__title">Режим работы</div>
                            <div class="contacts-info-item__value">Пн-Пт: 9:00 — 18:00</div>
                            <div class="contacts-info-item__desc">Сб-Вс: выходной</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Форма обратной связи -->
        <section class="contact-form-section">
            <div class="container">
                <div class="contact-form-card">
                    <div class="contact-form-left">
                        <h2 class="contact-form-title">СВЯЖИТЕСЬ<br><span class="gradient-text">С НАМИ</span></h2>
                        <p class="contact-form-text">
                            Оставьте заявку, и наш специалист свяжется с вами для консультации и подбора оборудования.
                        </p>
                        <div class="contact-form-contacts">
                            <p>📞 +7 (800) 123-45-67</p>
                            <p>✉️ info@medicator.ru</p>
                            <p>📍 г. Минск, ул. Толбухино, д.2</p>
                            <p>📍 г. Смоленск, ул. 2-я Вяземская, д.4</p>
                        </div>
                    </div>
                    
                    <div class="contact-form-right">
                        <?php if ($form_success): ?>
                            <div class="form-success">
                                ✅ Спасибо! Мы свяжемся с вами в ближайшее время.
                            </div>
                        <?php elseif ($form_error): ?>
                            <div class="form-error">
                                ❌ <?= $form_error ?>
                            </div>
                        <?php endif; ?>
                        
                        <form class="contact-form-fields" id="contact-form" method="POST">
                            <div class="form-field">
                                <label>Ваше имя *</label>
                                <input type="text" name="name" placeholder="Иван Иванов" required value="<?= htmlspecialchars($form_data['name'] ?? '') ?>">
                            </div>
                            <div class="form-field">
                                <label>Телефон *</label>
                                <input type="tel" name="phone" placeholder="+7 (___) ___-__-__" required value="<?= htmlspecialchars($form_data['phone'] ?? '') ?>">
                            </div>
                        
                            <div class="form-field">
                                <label>Сообщение</label>
                                <textarea name="message" rows="4" placeholder="Опишите ваш запрос..."><?= htmlspecialchars($form_data['message'] ?? '') ?></textarea>
                            </div>
                            <button type="submit" class="submit-btn">ОТПРАВИТЬ ЗАЯВКУ →</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Карта -->
        <section class="map">
            <div class="container">
                <h2 class="section-title">Мы на карте</h2>
                <div class="map-container">
                    <div id="map"></div>
                </div>
                <div style="text-align: center; margin-top: 15px; color: #64748b;">
                    <p>📍 г. Смоленск, ул. 2-я Вяземская, д.4</p>
                </div>
            </div>
        </section>

        <!-- Условия доставки -->
        <section class="delivery-section">
            <div class="container">
                <div class="delivery-card">
                    <h2 class="delivery-title">УСЛОВИЯ <span class="gradient-text">ДОСТАВКИ</span></h2>
                    <p class="delivery-subtitle">Доставляем по всей России быстро и надёжно</p>
                    
                    <div class="delivery-grid">
                        <div class="delivery-item">
                            <h3 class="delivery-item__title">Доставка по России</h3>
                            <p class="delivery-item__desc">Транспортными компаниями СДЭК, Деловые Линии, ПЭК. Срок — от 3 до 10 рабочих дней в зависимости от региона.</p>
                        </div>
                        
                        <div class="delivery-item">
                            <h3 class="delivery-item__title">Самовывоз</h3>
                            <p class="delivery-item__desc">Вы можете забрать заказ с нашего склада в Москве по предварительной договорённости.</p>
                        </div>
                        
                        <div class="delivery-item">
                            <h3 class="delivery-item__title">Гарантия сохранности</h3>
                            <p class="delivery-item__desc">Все товары надёжно упаковываются. В случае повреждения при доставке — бесплатная замена.</p>
                        </div>
                        
                        <div class="delivery-item">
                            <h3 class="delivery-item__title">Бесплатная доставка</h3>
                            <p class="delivery-item__desc">При заказе от 150 000 ₽ доставка по России за наш счёт.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Реквизиты -->
        <section class="requisites-section">
            <div class="container">
                <div class="requisites-card">
                    <h2 class="requisites-title"><span class="gradient-text">РЕКВИЗИТЫ</span></h2>
                    
                    <table class="requisites-table-full">
                        <tr>
                            <td>Наименование</td>
                            <td>ООО "МедикаДоз"</td>
                        </tr>
                        <tr>
                            <td>ИНН</td>
                            <td>7701234567</td>
                        </tr>
                        <tr>
                            <td>КПП</td>
                            <td>770101001</td>
                        </tr>
                        <tr>
                            <td>ОГРН</td>
                            <td>1177746123456</td>
                        </tr>
                        <tr>
                            <td>Юридический адрес</td>
                            <td>г. Москва, ул. Примерная, д. 1, оф. 101</td>
                        </tr>
                        <tr>
                            <td>Р/с</td>
                            <td>407028100000000012345</td>
                        </tr>
                        <tr>
                            <td>Банк</td>
                            <td>АО "Альфа-Банк"</td>
                        </tr>
                        <tr>
                            <td>БИК</td>
                            <td>044525593</td>
                        </tr>
                        <tr>
                            <td>К/с</td>
                            <td>30101810200000000593</td>
                        </tr>
                    </table>
                    
                    <a href="#" class="download-link">📎 Скачать реквизиты (PDF)</a>
                </div>
            </div>
        </section>
    </main>

    <?php require_once 'includes/footer.php'; ?>

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Яндекс карта
        function initMap() {
            if (typeof ymaps === 'undefined') {
                console.log('Yandex Maps API не загружен');
                showFallbackMap();
                return;
            }
            
            try {
                ymaps.ready(function() {
                    const mapElement = document.getElementById('map');
                    if (!mapElement) return;
                    
                    const coordinates = [54.782952, 32.026853];
                    
                    const map = new ymaps.Map('map', {
                        center: coordinates,
                        zoom: 17,
                        controls: ['zoomControl', 'fullscreenControl']
                    });
                    
                    const marker = new ymaps.Placemark(coordinates, {
                        balloonContentHeader: '7company',
                        balloonContentBody: 'г. Смоленск, 2-я Вяземская улица, д.4',
                        balloonContentFooter: 'Офис продаж'
                    }, {
                        preset: 'islands#redDotIcon',
                        iconColor: '#f97316'
                    });
                    
                    map.geoObjects.add(marker);
                    marker.balloon.open();
                });
            } catch (error) {
                console.log('Ошибка при создании карты:', error);
                showFallbackMap();
            }
        }

        function showFallbackMap() {
            const mapElement = document.getElementById('map');
            if (mapElement) {
                mapElement.innerHTML = `
                    <div style="width:100%;height:100%;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-direction:column;padding:20px;text-align:center;border-radius:12px;">
                        <div style="font-size:48px;margin-bottom:16px;">📍</div>
                        <p style="font-size:16px;margin-bottom:10px;color:#1e293b;">г. Смоленск, 2-я Вяземская улица, д.4</p>
                        <a href="https://yandex.ru/maps/?text=Смоленск,+2-я+Вяземская+улица,+д.4" 
                           target="_blank" 
                           style="color:#f97316;text-decoration:underline;">
                            Посмотреть на Яндекс.Картах
                        </a>
                    </div>
                `;
            }
        }
        
        setTimeout(initMap, 500);
    });
    </script>
    <script>
        (function(w,d,u){
                var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://cdn-ru.bitrix24.by/b15313854/crm/site_button/loader_2_el7etg.js');
</script>
</body>
</html>