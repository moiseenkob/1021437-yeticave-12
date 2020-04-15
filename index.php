<?php
require_once "mysql_connect.php";
require_once "helpers.php";
require_once "functions.php";

// запрос лотов
$sql_lots = "SELECT lot.id, lot.name, lot.price_start, lot.image_link, lot.created_at, lot.ends_at, category.name as category_name FROM `lots` as lot
INNER JOIN `categories` as category
ON lot.category_id = category.id
WHERE lot.ends_at > NOW()
ORDER BY `created_at` DESC LIMIT 6";
// выполнение запроса
$result_lots = mysqli_query($con, $sql_lots);
// получение двухмерного массива лотов
$lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);

$page_content = include_template("main.php", [
    "categories" => $categories,
    "lots" => $lots
]);

$layout_content = include_template("layout.php", [
    "main_content" => $page_content,
    "title_page" => "Главная страница",
    "user_name" => $_SESSION["user"]["name"] ?? "",
    "categories" => $categories,
]);

print($layout_content);
