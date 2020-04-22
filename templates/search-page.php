<?php
require_once "functions.php";
?>
<div class="container">
    <?php if(isset($empty_search)) : ?>
        <h2><?= $empty_search;?></h2>
    <? else : ?>
        <section class="lots">
            <h2>Результаты поиска по запросу «<span><?= $str_search;?></span>»</h2>
            <ul class="lots__list">
                <?php foreach ($lots as $lot) : ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= $lot["image_link"]; ?>" width="350" height="260" alt="Сноуборд">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= $lot["category_name"]; ?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$lot["id"];?>"><?= $lot["name"]; ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= format_sum($lot["price_start"]); ?></span>
                            </div>
                            <?php list($hours, $minutes) = get_dt_range($lot["ends_at"]);?>
                            <div class="lot__timer timer <?php if ($hours < 1) : ?>timer--finishing<?php endif;?>">
                                <?= $hours . ":" . $minutes;?>
                            </div>
                        </div>
                    </div>
                </li>
                <?endforeach;?>
            </ul>
        </section>
    <?php
        function render_pagination($path, $text_button, $string_search=NULL, $current_page=NULL,  $class_important=NULL, $disable_style=NULL)
        {
            $disable_style === 1 ? $disable_style = "style='pointer-events: none;'" : $disable_style = "";
            return "<li $disable_style class='pagination-item " . $class_important . "'><a href='" . $path . $string_search."&page=" . $current_page . "'>$text_button</a></li>";
        }
        // функция пагинации
        function get_pagination($all_lots, $value_items, $current_page, $pages, $str_search)
        {
            if ($all_lots > $value_items) {
                $pagination = "<ul class='pagination-list'>";

                if ($current_page === 1) {
                    $pagination .= render_pagination("#", "Назад", NULL,NULL, "pagination-item-prev", 1);
                } else {
                    $pagination .= render_pagination("search.php?search=", "Назад", $str_search, $current_page - 1, "pagination-item-prev", 0);
                }

                for ($i = 1; $i <= $pages; $i++) {
                    if ($current_page === $i) {
                        $pagination .= render_pagination("#", $i, NULL,NULL, "pagination-item-active", 1);
                    } else {
                        $pagination .= render_pagination("search.php?search=", $i, $str_search,$i, "", 0);
                    }
                }

                if ($pages > $current_page) {
                    $pagination .= render_pagination("search.php?search=", "Вперед", $str_search, $current_page + 1, "pagination-item-next", 0);
                } else {
                    $pagination .= render_pagination("#", "Вперед", NULL,NULL, "pagination-item-next", 1);
                }
                return $pagination .= "</ul>";
            }
            return false;
        }
        ?>
        <?php echo get_pagination($count_lots, COUNT_ITEMS, $current_page, $page_count, $str_search)?>
    <?endif;?>
</div>
