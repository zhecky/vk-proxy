<?php
/**
 * Created by PhpStorm.
 * User: zhecky
 * Date: 22.12.14
 * Time: 0:28
 */

?>
    <ul class="list-group">
<?php


foreach ($counters as $key => $value) {
?>

    <li class="list-group-item">
        <span class="badge"><?=$value?></span>
        <?=$key?>
    </li>

<?php } ?>

    </ul>