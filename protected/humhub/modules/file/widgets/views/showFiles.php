<?php

use humhub\modules\file\libs\FileHelper;
use humhub\modules\file\widgets\FilePreview;
use humhub\widgets\JPlayerPlaylistWidget;
use yii\helpers\Html;

/* @var  $showPreview boolean */
/* @var  $files \humhub\modules\file\models\File[] */
/* @var  $previewImage \humhub\modules\file\converter\PreviewImage */
/* @var  $object \humhub\components\ActiveRecord */
/* @var  $hideImageFileInfo boolean */

$videoExtensions = ['webm', 'mp4', 'ogv', 'mov'];
$images = [];
$videos = [];
$audios = [];

foreach($files as $file) {
    if ($previewImage->applyFile($file)) {
        $images[] = $file;
    } else if (in_array(FileHelper::getExtension($file->file_name), $videoExtensions, true)) {
        $videos[] = $file;
    } else if (FileHelper::getExtension($file->file_name) === 'mp3') {
        $audios[]  = $file;
    }
}
?>

<?php if (count($files) > 0) : ?>
<!-- hideOnEdit mandatory since 1.2 -->
<div class="hideOnEdit">
    <!-- Show Images as Thumbnails -->

    <?php if($showPreview) :?>
        <div class="post-files clearfix" id="post-files-<?= $object->getUniqueId() ?>">

            <?php if(!empty($audios)) : ?>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?= JPlayerPlaylistWidget::widget(['playlist' => $audios]) ?>
                </div>
            <?php endif; ?>

            <?php foreach ($videos as $video): ?>
                <?php if (FileHelper::getExtension($video->file_name) === 'webm'): ?>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <a data-ui-gallery="<?= 'gallery-' . $object->getUniqueId() ?>" href="<?= $video->getUrl(); ?>#.webm" title="<?= Html::encode($video->file_name) ?>">
                            <video src="<?= $video->getUrl() ?>" type="video/webm" controls preload="metadata" height="130"></video>
                        </a>
                    </div>
                <?php elseif (FileHelper::getExtension($video->file_name) === 'mp4'): ?>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <a data-ui-gallery="<?= 'gallery-' . $object->getUniqueId() ?>" href="<?= $video->getUrl(); ?>#.mp4" title="<?= Html::encode($video->file_name) ?>">
                            <video src="<?= $video->getUrl() ?>" type="video/mp4" controls preload="metadata" height="130"></video>
                        </a>
                    </div>
                <?php elseif (FileHelper::getExtension($video->file_name) === 'ogv'): ?>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <a data-ui-gallery="<?= 'gallery-' . $object->getUniqueId() ?>" href="<?= $video->getUrl(); ?>#.ogv" title="<?= Html::encode($video->file_name) ?>">
                            <video src="<?= $video->getUrl() ?>" type="video/ogg" controls preload="metadata" height="130"></video>
                        </a>
                    </div>
                <?php elseif (FileHelper::getExtension($video->file_name) === 'mov'): ?>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <a data-ui-gallery="<?= 'gallery-' . $object->getUniqueId() ?>" href="<?= $video->getUrl(); ?>#.mov" title="<?= Html::encode($video->file_name) ?>">
                            <video src="<?= $video->getUrl() ?>" type="video/quicktime" controls preload="metadata" height="130"></video>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach ?>

            <?php foreach ($images as $image): ?>
                <?php $previewImage->applyFile($image) ?>
                <div class="col-xs-6 col-sm-4 col-md-4" style="margin-bottom:10px">
                    <a data-ui-gallery="<?= 'gallery-' . $object->getUniqueId(); ?>" href="<?= $image->getUrl() ?>#.jpeg" title="<?= Html::encode($image->file_name) ?>">
                        <?= $previewImage->render() ?>
                    </a>
                </div>
            <?php endforeach; ?>

        </div>
    <?php endif; ?>

    <!-- Show List of all files -->
    <?= FilePreview::widget([
        'hideImageFileInfo' => $hideImageFileInfo,
        'items' => $files,
        'model' => $object,
    ]) ?>

</div>
<?php endif; ?>

