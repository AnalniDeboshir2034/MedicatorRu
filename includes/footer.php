<?php
require_once __DIR__ . '/site_settings.php';
$siteSettings = $siteSettings ?? load_site_settings();
?>
<footer class="footer">
        <div class="container">
            <div class="footer__content">
                <div class="footer__col">
                    <a href="index.php" class="footer-logo"><?= htmlspecialchars($siteSettings['header']['brand_name']) ?></a>
                    <p class="footer__text"><?= htmlspecialchars($siteSettings['footer']['company_description']) ?></p>
                </div>
                <div class="footer__col">
                    <h3 class="footer__title">Контакты</h3>
                    <ul class="footer__list">
                        <li>📞 <?= htmlspecialchars($siteSettings['contacts']['phone']) ?></li>
                        <li>✉️ <?= htmlspecialchars($siteSettings['contacts']['email']) ?></li>
                        <li>📍 <?= htmlspecialchars($siteSettings['contacts']['address']) ?></li>
                    </ul>
                </div>
                <div class="footer__col">
                    <h3 class="footer__title">Навигация</h3>
                    <ul class="footer__list">
                        <li><a href="index.php">Главная</a></li>
                        <li><a href="catalog.php">Каталог</a></li>
                        <li><a href="contacts.php">Контакты</a></li>
                    </ul>
                </div>
                <div class="footer__col">
                    <h3 class="footer__title">Часы работы</h3>
                    <ul class="footer__list">
                        <li><?= htmlspecialchars($siteSettings['contacts']['work_hours']) ?></li>
                        <li>Сб-Вс: Выходной</li>
                    </ul>
                </div>
            </div>
            <div class="footer__bottom">
                <p><?= htmlspecialchars($siteSettings['footer']['copyright']) ?></p>
            </div>
        </div>
    </footer>