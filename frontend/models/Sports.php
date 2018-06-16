<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "sports".
 *
 * @property int $id
 * @property string $name
 * @property string $logo
 * @property string $description
 * @property string $title
 */
class Sports extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'logo', 'description', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'logo' => 'Logo',
            'description' => 'Description',
            'title' => 'Title',
        ];
    }
}
