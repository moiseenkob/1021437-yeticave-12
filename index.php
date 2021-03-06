<?php
require_once "init.php";
require_once "helpers.php";
require_once "get_winner.php";

$sql_lots = "SELECT 
    lot.id, 
    lot.name, 
    lot.price_start, 
    lot.image_link, 
    lot.created_at, 
    lot.ends_at, 
    category.name AS category_name 
    FROM `lots` AS lot
    INNER JOIN `categories` AS category
    ON lot.category_id = category.id
    WHERE lot.ends_at > NOW()
    ORDER BY `created_at` DESC LIMIT " . COUNT_ITEMS;
$result_lots = mysqli_query($con, $sql_lots);
get_error($con);
$lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);

$page_content = include_template("main.php", [
    "categories" => $categories,
    "lots" => $lots ?? [],
]);

$layout_content = include_template("layout.php", [
    "main_content" => $page_content,
    "title_page" => "Главная страница",
    "user_name" => get_value_from_user_session("name"),
    "categories" => $categories,
]);

print($layout_content);
