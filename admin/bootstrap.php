<?php
session_start();

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/site_settings.php';

$adminLogin = 'admin';
$adminPassword = 'admin123';

function admin_req($key)
{
    return trim($_POST[$key] ?? '');
}

if (isset($_POST['admin_logout'])) {
    unset($_SESSION['is_admin']);
    header('Location: index.php');
    exit;
}

if (isset($_POST['admin_login'])) {
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if ($login === $adminLogin && $password === $adminPassword) {
        $_SESSION['is_admin'] = true;
        header('Location: index.php');
        exit;
    }
    $_SESSION['admin_login_error'] = 'Неверный логин или пароль';
    header('Location: index.php');
    exit;
}

function admin_require_auth()
{
    if (empty($_SESSION['is_admin'])) {
        header('Location: index.php');
        exit;
    }
}

function admin_page_start($title)
{
    ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($title) ?></title>
        <style>
            body { font-family: Arial, sans-serif; background: #f5f7fb; margin: 0; }
            .wrap { max-width: 1200px; margin: 0 auto; padding: 16px; }
            .top { display: flex; justify-content: space-between; align-items: center; gap: 10px; }
            .card { background: #fff; border-radius: 12px; padding: 16px; margin: 16px 0; }
            .grid { display: grid; grid-template-columns: repeat(2, minmax(250px,1fr)); gap: 10px; }
            input, textarea, select { width: 100%; padding: 8px; margin: 4px 0; box-sizing: border-box; }
            table { width: 100%; border-collapse: collapse; font-size: 14px; }
            td, th { border: 1px solid #e4e7f1; padding: 6px; text-align: left; vertical-align: top; }
            button { padding: 8px 12px; border: 0; border-radius: 8px; background: #1f5cff; color: #fff; cursor: pointer; }
            .danger { background: #c62828; }
            .muted { color: #666; font-size: 13px; }
            .nav { display: flex; flex-wrap: wrap; gap: 8px; margin: 10px 0; }
            .nav a { text-decoration: none; background: #fff; color: #1f5cff; border-radius: 8px; padding: 8px 10px; border: 1px solid #d6ddff; }
            .msg { background: #e9fff2; border: 1px solid #c6f3da; color: #075f33; padding: 10px; border-radius: 10px; margin: 10px 0; }
        </style>
    </head>
    <body>
    <div class="wrap">
        <div class="top">
            <h1><?= htmlspecialchars($title) ?></h1>
            <form method="post">
                <button type="submit" name="admin_logout" value="1" class="danger">Выйти</button>
            </form>
        </div>
        <div class="nav">
            <a href="index.php">Главная админки</a>
            <a href="medicators.php">Медикаторы</a>
            <a href="gallery.php">Галерея</a>
            <a href="filters.php">Фильтры / Субфильтры</a>
            <a href="settings.php">JSON настройки</a>
        </div>
    <?php
}

function admin_page_end()
{
    echo '</div></body></html>';
}

