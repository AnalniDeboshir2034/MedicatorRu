<?php
require_once __DIR__ . '/bootstrap.php';
admin_require_auth();

$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'settings_save') {
    $current = load_site_settings();
    $current['contacts']['phone'] = admin_req('contact_phone');
    $current['contacts']['email'] = admin_req('contact_email');
    $current['contacts']['address'] = admin_req('contact_address');
    $current['contacts']['work_hours'] = admin_req('contact_work_hours');
    $current['header']['brand_name'] = admin_req('header_brand_name');
    $current['header']['lead_button_text'] = admin_req('header_lead_button_text');
    $current['footer']['company_description'] = admin_req('footer_company_description');
    $current['footer']['copyright'] = admin_req('footer_copyright');
    $current['index']['hero_title_top'] = admin_req('hero_title_top');
    $current['index']['hero_title_bottom'] = admin_req('hero_title_bottom');
    $current['index']['hero_text'] = admin_req('hero_text');
    $current['containers']['index_cta_title'] = admin_req('index_cta_title');
    $current['containers']['index_cta_subtitle'] = admin_req('index_cta_subtitle');
    $current['containers']['contacts_intro_title'] = admin_req('contacts_intro_title');
    $current['containers']['contacts_intro_subtitle'] = admin_req('contacts_intro_subtitle');
    save_site_settings($current);
    $success = 'JSON настройки сохранены';
}

$settings = load_site_settings();
admin_page_start('Админка: JSON настройки');
if ($success) {
    echo '<div class="msg">' . htmlspecialchars($success) . '</div>';
}
?>
<div class="card">
    <h2>Настройки сайта (JSON)</h2>
    <p class="muted">Изменения применяются к `index.php`, `contacts.php`, `includes/header.php`, `includes/footer.php`.</p>
    <form method="post">
        <input type="hidden" name="action" value="settings_save">
        <div class="grid">
            <input name="contact_phone" value="<?= htmlspecialchars($settings['contacts']['phone']) ?>" placeholder="Телефон">
            <input name="contact_email" value="<?= htmlspecialchars($settings['contacts']['email']) ?>" placeholder="Email">
            <input name="contact_address" value="<?= htmlspecialchars($settings['contacts']['address']) ?>" placeholder="Адрес">
            <input name="contact_work_hours" value="<?= htmlspecialchars($settings['contacts']['work_hours']) ?>" placeholder="Часы работы">
            <input name="header_brand_name" value="<?= htmlspecialchars($settings['header']['brand_name']) ?>" placeholder="Название бренда">
            <input name="header_lead_button_text" value="<?= htmlspecialchars($settings['header']['lead_button_text']) ?>" placeholder="Текст кнопки в хедере">
            <input name="footer_company_description" value="<?= htmlspecialchars($settings['footer']['company_description']) ?>" placeholder="Описание в футере">
            <input name="footer_copyright" value="<?= htmlspecialchars($settings['footer']['copyright']) ?>" placeholder="Copyright">
            <input name="hero_title_top" value="<?= htmlspecialchars($settings['index']['hero_title_top']) ?>" placeholder="Hero title top">
            <input name="hero_title_bottom" value="<?= htmlspecialchars($settings['index']['hero_title_bottom']) ?>" placeholder="Hero title bottom">
            <input name="index_cta_title" value="<?= htmlspecialchars($settings['containers']['index_cta_title']) ?>" placeholder="Index CTA title">
            <input name="index_cta_subtitle" value="<?= htmlspecialchars($settings['containers']['index_cta_subtitle']) ?>" placeholder="Index CTA subtitle">
            <input name="contacts_intro_title" value="<?= htmlspecialchars($settings['containers']['contacts_intro_title']) ?>" placeholder="Contacts title">
            <input name="contacts_intro_subtitle" value="<?= htmlspecialchars($settings['containers']['contacts_intro_subtitle']) ?>" placeholder="Contacts subtitle">
        </div>
        <textarea name="hero_text" placeholder="Hero text"><?= htmlspecialchars($settings['index']['hero_text']) ?></textarea>
        <button>Сохранить JSON</button>
    </form>
</div>
<?php admin_page_end(); ?>

