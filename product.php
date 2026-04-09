<?php 
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/bbcode.php';

if (!$mysqli || $mysqli->connect_error) {
    die("❌ Нет соединения с БД");
}

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

if (empty($slug)) {
    header('Location: index.php');
    exit;
}

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

if (empty($images)) {
    $images[] = ['path_img' => '', 'is_Main' => 1];
}

$stmt = $mysqli->prepare("
    INSERT INTO medicator_view (medicator_id, medicator_name, view_data, view_count) 
    VALUES (?, ?, CURDATE(), 1)
    ON DUPLICATE KEY UPDATE view_count = view_count + 1
");
$stmt->bind_param("is", $product['id'], $product['name']);
$stmt->execute();

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

$relatedProducts = [];
$relatedSeen = [];
$stmt = $mysqli->prepare("
    SELECT m.*,
           (SELECT path_img FROM medicator_img WHERE medicator_id = m.id AND is_Main = 1 LIMIT 1) as main_img
    FROM medicator m
    WHERE m.id != ? AND m.filtr = ?
    ORDER BY m.id DESC
    LIMIT 8
");
$stmt->bind_param("is", $product['id'], $product['filtr']);
$stmt->execute();
$resRelated = $stmt->get_result();
while ($resRelated && ($row = $resRelated->fetch_assoc())) {
    $rid = (int)$row['id'];
    if (!isset($relatedSeen[$rid])) {
        $relatedSeen[$rid] = true;
        $relatedProducts[] = $row;
    }
}

if (count($relatedProducts) < 4) {
    $stmt = $mysqli->prepare("
        SELECT m.*,
               (SELECT path_img FROM medicator_img WHERE medicator_id = m.id AND is_Main = 1 LIMIT 1) as main_img
        FROM medicator m
        WHERE m.id != ?
        ORDER BY m.id DESC
        LIMIT 8
    ");
    $stmt->bind_param("i", $product['id']);
    $stmt->execute();
    $resAny = $stmt->get_result();
    while ($resAny && ($row = $resAny->fetch_assoc())) {
        $rid = (int)$row['id'];
        if (!isset($relatedSeen[$rid])) {
            $relatedSeen[$rid] = true;
            $relatedProducts[] = $row;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <base href="/" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/products/favico.png">
    <title><?= htmlspecialchars($product['name']) ?> | Medikator.ru</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/product.css">
</head>
<body>
    <?php require_once __DIR__ . '/includes/header.php'; ?>

    <main class="main">
        <div class="container">
            <div class="breadcrumbs">
                <a href="/">Главная</a> /
                <a href="/catalog">Каталог</a> /
                <?php if ($product['filter_name']): ?>
                <a href="/catalog?category=<?= rawurlencode($product['filter_slug']) ?>">
                    <?= htmlspecialchars($product['filter_name']) ?>
                </a> /
                <?php endif; ?>
                <span><?= htmlspecialchars($product['name']) ?></span>
            </div>

            <div class="product-page">
                <div class="product-left">
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

                    <div class="product-tabs">
                        <div class="tabs-header">
                            <button class="tab-btn active" data-tab="description">Описание</button>
                            <button class="tab-btn" data-tab="docs">Документация</button>
                        </div>
                        
                        <div class="tabs-content">
                            <div class="tab-pane active" id="tab-description">
                                <div class="product-description">
                                    <?php if (!empty($product['opis'])): ?>
                                        <?= bbcode_to_html($product['opis']) ?>
                                    <?php else: ?>
                                        <p>Описание товара отсутствует</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
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
                                                <div class="doc-download">Скачать</div>
                                            </a>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($product['user_pass'])): ?>
                                            <a href="<?= htmlspecialchars($product['user_pass']) ?>" class="doc-item" target="_blank">
                                                <div class="doc-icon">📖</div>
                                                <div class="doc-info">
                                                    <div class="doc-title">Руководство пользователя</div>
                                                    <div class="doc-size">PDF документ</div>
                                                </div>
                                                <div class="doc-download">Скачать</div>
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
                        <a href="#" class="btn btn-order open-modal-form" data-form="hero">Заказать</a>
                        <button
                            type="button"
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
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php if (!empty($relatedProducts)): ?>
    <section class="related-products">
        <div class="container">
            <h2 class="section-title">Похожие <span class="gradient-text">товары</span></h2>
            <div class="related-products__list">
                <?php foreach ($relatedProducts as $rp): ?>
                    <article class="related-product-card">
                        <div class="related-product-card__image">
                            <img src="<?= htmlspecialchars($rp['main_img'] ?? 'products/medikator.jpg') ?>" alt="<?= htmlspecialchars($rp['name']) ?>">
                        </div>
                        <div class="related-product-card__body">
                            <h3><?= htmlspecialchars($rp['name']) ?></h3>
                            <p><?= htmlspecialchars($rp['filtr'] ?? 'Серия') ?></p>
                            <a class="btn btn-primary" href="/product/<?= rawurlencode($rp['slug']) ?>">Подробнее</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>
    <?php $mysqli->close(); ?>
    
    <script src="js/product.js"></script>
    <script>
        (function(w,d,u){
                var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://cdn-ru.bitrix24.by/b15313854/crm/site_button/loader_2_el7etg.js');
</script>
</body>
</html>