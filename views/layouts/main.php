<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

$googleTagID = isset(Yii::$app->params['googleTagID']) ? Yii::$app->params['googleTagID'] : '';
$isCollapse = isset($_SESSION['sidebarCollapse']) ? $_SESSION['sidebarCollapse'] : null;
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" style="background: #ECF0F5;">

<head>
    <meta name="robots" content="noindex" />
    <meta name="googlebot-news" content="noindex" />
    <meta name="googlebot" content="noindex" />
    <meta name="googlebot-news" content="nosnippet" />
    <meta name="google-site-verification" content="Z62hJzzednQrug2c8CqVFHIigqkH6qDENSh-3-SWW_A" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo Yii::$app->request->baseUrl; ?>/favicon_new.ico" type="image/x-icon" />
    <?= Html::csrfMetaTags() ?>
    <title>ESB - Invoice</title>
    <?php $this->head() ?>
</head>

<body class="hold-transition skin-blue sidebar-mini <?= $isCollapse == 1 ? 'sidebar-collapse' : '' ?>">
    <div id="loading-div"></div>
    <?php $this->beginBody() ?>

    <div class="wrapper">
        <?php if (!isset($this->params['browse'])) : ?>

            <?=
            $this->render(
                'left.php',
                ['directoryAsset' => $directoryAsset]
            )
            ?>
        <?php endif ?>

        <?=
        $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        )
        ?>
    </div>

    <div class="hidden">
        <?= kartik\widgets\Select2::widget(['name' => 'selectName']); ?>
    </div>

    <div id="ModalDialogContainer" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" id="ModalDialogBody">
                </div>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>