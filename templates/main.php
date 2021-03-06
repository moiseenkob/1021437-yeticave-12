<?php
require_once "functions.php";
?>
<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">
        На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.
    </p>
    <ul class="promo__list">
        <?php foreach ($categories as $category) : ?>
            <li class="promo__item promo__item--<?= htmlspecialchars($category["code"], ENT_QUOTES); ?>">
                <a class="promo__link"
                   href="all-lots.php?category=<?= htmlspecialchars($category["code"], ENT_QUOTES); ?>"><?= htmlspecialchars($category["name"], ENT_QUOTES); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <?php if (!empty($lots)) : ?>
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <?php foreach ($lots as $lot) : ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= htmlspecialchars($lot["image_link"], ENT_QUOTES); ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= htmlspecialchars($lot["category_name"], ENT_QUOTES) ?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $lot["id"]; ?>"><?= htmlspecialchars($lot["name"], ENT_QUOTES) ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= htmlspecialchars(format_sum($lot["price_start"]), ENT_QUOTES); ?></span>
                            </div>
                            <?php list($hours, $minutes) = get_dt_range($lot["ends_at"]); ?>
                            <div class="lot__timer timer <?= ($hours < 1) ? 'timer--finishing' : ''; ?>">
                                <?= "$hours : $minutes"; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <div class="lots__header">
            <h2>Нет открытых лотов</h2>
        </div>
    <?php endif; ?>
</section>
