<?php

namespace humhub\modules\live\models;

use humhub\modules\content\models\ContentContainer;

/**
 * This is the model class for table "live".
 *
 * @property integer $id
 * @property integer $contentcontainer_id
 * @property integer $visibility
 * @property string $serialized_data
 * @property integer $created_at
 *
 * @property Contentcontainer $contentcontainer
 */
class Live extends \humhub\components\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'live';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contentcontainer_id', 'visibility', 'created_at'], 'integer'],
            [['serialized_data', 'created_at'], 'required'],
            [['serialized_data'], 'string'],
            [['contentcontainer_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContentContainer::class, 'targetAttribute' => ['contentcontainer_id' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentcontainer()
    {
        return $this->hasOne(Contentcontainer::class, ['id' => 'contentcontainer_id']);
    }

}
