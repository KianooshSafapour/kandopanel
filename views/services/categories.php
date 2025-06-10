<?php
$style = (int)kando_get_option('service-style', 2);
if ($style == 1) {
    include(SAMYAR_DIR_VIEW . '/services/service/style1.php');
} else {
    include(SAMYAR_DIR_VIEW . '/services/service/style2.php');
}