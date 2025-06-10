<?php
defined('ABSPATH') || exit('No Access!');
?>
<ul class="sortable sortable-categories">
    <?php
    $c=0;
    foreach ($menus as $tab) {

    ?>
    <li class="term_type_li <?php echo $tab['action'] ?> <?php if (!$tab['enable']) echo 'opacity6' ?>" data-item="<?php echo $tab['action'] ?>">
        <input type="hidden" name="menu[<?php echo $c; ?>][action]" value="<?php echo $tab['action']; ?>">
        <input type="hidden" name="menu[<?php echo $c; ?>][link]" value="<?php echo $tab['link']; ?>">
        <input type="hidden" name="menu[<?php echo $c; ?>][section]" value="<?php echo $tab['section']; ?>">
        <input type="hidden" name="menu[<?php echo $c; ?>][for_admin]" value="<?php echo $tab['for_admin']; ?>">
        <input type="hidden" name="menu[<?php echo $c; ?>][data-intro]" value="<?php echo $tab['data-intro']??""; ?>">
        <input type="hidden" name="menu[<?php echo $c; ?>][data-position]" value="<?php echo $tab['data-position']??""; ?>">
        <div class="manage-category-block" style="display: flex">
            <span class="reorder-grabber"><i uk-icon="icon: menu" style="margin-top: 18px;"></i></span>
            <div class="fields tight cf" style="padding-right:80px;">
                    <span id="category_thumb_uploader_<?php echo $tab['action']; ?>" data-category="<?php echo $tab['action']; ?>" class="category-thumb-uploader category-thumb icon-select">

                        <span class="img-holder">
                            <?php
                            $class = "fas fa-plus";
                            if (!empty($tab['icon'])) {
                                $class = $tab['icon'];
                            }

                            ?>
                            <i class="<?= $class ?>" title="<?php _e('Add Icon', SAMYAR_TEXT_DOMAIN) ?>"></i>
                            <input type="hidden" name="menu[<?php echo $c; ?>][icon]" value="<?php echo $tab['icon']; ?>">
                        </span>

                    </span>
            </div>

            <span class="input" style="margin:0 10px"><input type="text" class="uk-input icon-text" name="menu[<?php echo $c; ?>][icon]" value="<?= $class ?>"></span>
            <span class="input" style="margin:0 10px;flex-grow: 3"><input type="text" class="uk-input" name="menu[<?php echo $c; ?>][name]" disabled value="<?php echo $tab['name']; ?>"></span>

            <span class="menu-status" data-endpoint="<?php echo $tab['action']; ?>">
                    <input type="hidden" name="menu[<?php echo $c; ?>][enable]" value="0">
                    <input type="checkbox" name="menu[<?php echo $c; ?>][enable]" <?php checked($tab['enable'], 1); ?> value="1">
                </span>
            <?php
    $c++;
    } ?>
        </div>


    </li>

</ul>