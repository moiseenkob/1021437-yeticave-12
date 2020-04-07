<?php
require_once 'functions.php';
?>
<section class="lot-item container">
    <h2><?= $lot['name'];?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= $lot['image_link'];?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?= $lot['category_name'];?></span></p>
            <p class="lot-item__description">
                <?= $lot['description'];?>
            </p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <?php
                    list($hours, $minutes) = get_dt_range($lot['ends_at']);
                ?>
                <div class="lot-item__timer timer <?php if ($hours < 1) : ?>timer--finishing<?php endif;?>">
                    <?php
                        echo $hours . ":" . $minutes;
                    ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= format_sum(get_max_price_bids($bids, $lot['price_start']))?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?=format_sum($lot['step_rate'])?></span>
                    </div>
                </div>
                <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post" autocomplete="off">
                    <p class="lot-item__form-item form__item form__item--invalid">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost" placeholder="12 000">
                        <span class="form__error">Введите наименование лота</span>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <div class="history">
                <h3>История ставок (<span><?= count($bids);?></span>)</h3>
                <table class="history__list">
                    <?php foreach ($bids as $bid) : ?>
                    <tr class="history__item">
                        <td class="history__name"><?=$bid['name']?></td>
                        <td class="history__price"><?=format_sum($bid['price'])?></td>
                        <td class="history__time"><?=$bid['created_at']?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>
