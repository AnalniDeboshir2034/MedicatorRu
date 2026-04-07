<?php 
require_once __DIR__ . '/includes/config.php';

// Проверка подключения
if (!$mysqli || $mysqli->connect_error) {
    die("❌ Нет соединения с БД");
}

// Получаем slug из URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

if (empty($slug)) {
    header('Location: index.php');
    exit;
}

// Получаем информацию о товаре
$product = null;
$stmt = $mysqli->prepare("
    SELECT m.*, 
           f.name as filter_name,
           f.slug as filter_slug
    FROM `medicator` m 
    LEFT JOIN `filter` f ON m.filtr = f.slug
    WHERE m.slug = ?
");
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    header('Location: index.php');
    exit;
}

// Получаем все изображения товара
$images = [];
$stmt = $mysqli->prepare("
    SELECT * FROM `medicator_img` 
    WHERE medicator_id = ? 
    ORDER BY sort ASC, id ASC
");
$stmt->bind_param("i", $product['id']);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $images[] = $row;
}

// Если нет изображений, добавляем плейсхолдер
if (empty($images)) {
    $images[] = ['path_img' => '', 'is_Main' => 1];
}

// Добавляем просмотр
$stmt = $mysqli->prepare("
    INSERT INTO medicator_view (medicator_id, medicator_name, view_data, view_count) 
    VALUES (?, ?, CURDATE(), 1)
    ON DUPLICATE KEY UPDATE view_count = view_count + 1
");
$stmt->bind_param("is", $product['id'], $product['name']);
$stmt->execute();

// Получаем количество просмотров
$views = 0;
$stmt = $mysqli->prepare("
    SELECT SUM(view_count) as total_views 
    FROM medicator_view 
    WHERE medicator_id = ?
");
$stmt->bind_param("i", $product['id']);
$stmt->execute();
$result = $stmt->get_result();
$viewsRow = $result->fetch_assoc();
$views = $viewsRow['total_views'] ?? 0;

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> | 7company</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/product.css">
</head>
<body>
    <?php require_once __DIR__ . '/includes/header.php'; ?>

    <main class="main">
        <div class="container">
            <!-- Хлебные крошки -->
            <div class="breadcrumbs">
                <a href="index.php">Главная</a> /
                <a href="catalog.php">Каталог</a> /
                <?php if ($product['filter_name']): ?>
                <a href="catalog.php?category=<?= urlencode($product['filter_slug']) ?>">
                    <?= htmlspecialchars($product['filter_name']) ?>
                </a> /
                <?php endif; ?>
                <span><?= htmlspecialchars($product['name']) ?></span>
            </div>

            <div class="product-page">
                <!-- Левая колонка - Галерея + Табы -->
                <div class="product-left">
                    <!-- Галерея -->
                    <div class="product-gallery">
                        <div class="gallery-main">
                            <?php foreach ($images as $index => $img): ?>
                            <div class="gallery-slide" data-index="<?= $index ?>" style="display: <?= $index === 0 ? 'flex' : 'none' ?>;">
                                <?php if (!empty($img['path_img'])): ?>
                                    <img src="<?= htmlspecialchars($img['path_img']) ?>" 
                                         alt="<?= htmlspecialchars($product['name']) ?>">
                                <?php else: ?>
                                    <div class="no-image-placeholder">
                                        <span>📷</span>
                                        <p><?= htmlspecialchars($product['name']) ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <?php if (count($images) > 1): ?>
                        <div class="gallery-nav">
                            <button class="gallery-prev" id="galleryPrev">‹</button>
                            <div class="gallery-thumbs">
                                <?php foreach ($images as $index => $img): ?>
                                <div class="thumb" data-index="<?= $index ?>">
                                    <?php if (!empty($img['path_img'])): ?>
                                        <img src="<?= htmlspecialchars($img['path_img']) ?>" alt="Миниатюра">
                                    <?php else: ?>
                                        <div class="thumb-placeholder">📷</div>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="gallery-next" id="galleryNext">›</button>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Табы (под галереей) -->
                    <div class="product-tabs">
                        <div class="tabs-header">
                            <button class="tab-btn active" data-tab="description">Описание</button>
                            <button class="tab-btn" data-tab="docs">Документация</button>
                        </div>
                        
                        <div class="tabs-content">
                            <!-- Таб Описание -->
                            <div class="tab-pane active" id="tab-description">
                                <div class="product-description">
                                    <?php if (!empty($product['opis'])): ?>
                                        <p><?= nl2br(htmlspecialchars($product['opis'])) ?></p>
                                    <?php else: ?>
                                        <p>Описание товара отсутствует</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Таб Документация -->
                            <div class="tab-pane" id="tab-docs">
                                <div class="product-docs">
                                    <?php if (!empty($product['passport']) || !empty($product['user_pass'])): ?>
                                        <div class="docs-list">
                                            <?php if (!empty($product['passport'])): ?>
                                            <a href="<?= htmlspecialchars($product['passport']) ?>" class="doc-item" target="_blank">
                                                <div class="doc-icon">📄</div>
                                                <div class="doc-info">
                                                    <div class="doc-title">Паспорт изделия</div>
                                                    <div class="doc-size">PDF документ</div>
                                                </div>
                                                <div class="doc-download">Скачать →</div>
                                            </a>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($product['user_pass'])): ?>
                                            <a href="<?= htmlspecialchars($product['user_pass']) ?>" class="doc-item" target="_blank">
                                                <div class="doc-icon">📖</div>
                                                <div class="doc-info">
                                                    <div class="doc-title">Руководство пользователя</div>
                                                    <div class="doc-size">PDF документ</div>
                                                </div>
                                                <div class="doc-download">Скачать →</div>
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <p>Документация отсутствует</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-right">
                    <div class="product-badge">
                        <?= htmlspecialchars($product['filter_name'] ?? 'Медикатор') ?>
                    </div>
                    <h1 class="product-title"><?= htmlspecialchars($product['name']) ?></h1>
                                        

                    <div class="product-specs">
                        <h3>Технические характеристики</h3>
                        <div class="specs-grid">
                            <?php if (!empty($product['d_dosing'])): ?>
                            <div class="spec-item">
                                <span class="spec-label">Диапазон дозирования</span>
                                <span class="spec-value"><?= htmlspecialchars($product['d_dosing']) ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($product['performance'])): ?>
                            <div class="spec-item">
                                <span class="spec-label">Производительность</span>
                                <span class="spec-value"><?= htmlspecialchars($product['performance']) ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($product['pressure'])): ?>
                            <div class="spec-item">
                                <span class="spec-label">Рабочее давление</span>
                                <span class="spec-value"><?= htmlspecialchars($product['pressure']) ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($product['temperature'])): ?>
                            <div class="spec-item">
                                <span class="spec-label">Температура жидкости</span>
                                <span class="spec-value"><?= htmlspecialchars($product['temperature']) ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($product['connections'])): ?>
                            <div class="spec-item">
                                <span class="spec-label">Тип подключения</span>
                                <span class="spec-value"><?= htmlspecialchars($product['connections']) ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($product['m_seal'])): ?>
                            <div class="spec-item">
                                <span class="spec-label">Материал уплотнений</span>
                                <span class="spec-value"><?= htmlspecialchars($product['m_seal']) ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($product['m_case'])): ?>
                            <div class="spec-item">
                                <span class="spec-label">Материал корпуса</span>
                                <span class="spec-value"><?= htmlspecialchars($product['m_case']) ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($product['dop'])): ?>
                            <div class="spec-item">
                                <span class="spec-label">Дополнительно</span>
                                <span class="spec-value"><?= htmlspecialchars($product['dop']) ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="product-actions">
                        <a href="catalog.php" class="btn btn-secondary">← Вернуться к каталогу</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>
    
    <script src="js/product.js"></script>
    <script>
        (function(w,d,u){
                var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://cdn-ru.bitrix24.by/b15313854/crm/site_button/loader_2_el7etg.js');
</script>
</body>
</html>