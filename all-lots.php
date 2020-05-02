<?php
require_once "init.php";
require_once "helpers.php";

if (isset($_GET["category"]) && $_GET["category"] !== "") {
    list($count_lots, $page_count) = compute_pagination_offset_and_limit($con, "SELECT COUNT(`lots`.`id`) as 'count' FROM `lots` 
    JOIN `categories`
    ON `categories`.`id` = `lots`.`category_id`
    WHERE `ends_at` > NOW() and `categories`.`code` = ?", $_GET["category"]);
    $current_page = get_value("page", 1);
    $offset = get_offset_items($current_page,COUNT_ITEMS);
    $current_category = get_escape_string($con, $_GET["category"]);
    $sql_query_lots_category = "SELECT lots.id, lots.image_link, lots.name, categories.name as category, categories.code, lots.ends_at, 
(SELECT IF (MAX(bids.price) = NULL, MAX(bids.price), lots.price_start)  FROM `bids` as bids WHERE bids.lot_id = lots.id) as price,
(SELECT COUNT(id) FROM `bids` as bids WHERE bids.lot_id = lots.id) as count_bets
FROM `lots` as lots
JOIN `categories` as categories
ON lots.category_id = categories.id
WHERE lots.ends_at > NOW() and categories.code = '" . $current_category . "' ORDER BY lots.created_at DESC LIMIT " . COUNT_ITEMS . " OFFSET " . $offset;
    $lots_result = mysqli_query($con, $sql_query_lots_category);
    $lots = mysqli_fetch_all($lots_result, MYSQLI_ASSOC);
    $page_content = include_template("lots.php", [
        "categories" => $categories,
        "lots" => $lots,
        "current_category" => $current_category ?? "",
        "count_lots" => $count_lots,
        "page_count" => $page_count,
        "current_page" => $current_page,
    ]);
} else {
    http_response_code(403);
    $page_content = include_template("error.php", [
        "categories" => $categories,
        "code_error" => "403",
        "text_error" => "Для просмотра лотов необходимо выбрать категорию и нажать по ней",
        "view_categories" => true,
    ]);
}

$layout_content = include_template("layout.php", [
    "main_content" => $page_content,
    "title_page" => "Страница лота",
    "user_name" => session_user_value("name", ""),
    "categories" => $categories,
]);

print($layout_content);