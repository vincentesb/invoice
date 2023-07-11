<?php

use yii\widgets\Breadcrumbs;

?>
<div class="content-wrapper">
    <section class="content-header" style="margin: 0px 25px;">
        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        )
        ?>
    </section>
    <section class="content">
        <?= $content ?>
    </section>
</div>