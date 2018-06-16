<?php

namespace frontend\models;

use common\models\content\ImageInterface;
use common\models\content\UrlInterface;
use common\models\project\Tournament;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "tournaments".
 *
 * @property int $id
 * @property int $sport_id
 * @property string $ts_created
 * @property string $ts_begin
 * @property string $ts_end
 * @property int $notify_before
 * @property string $description
 * @property string $img
 * @property string $contact_phone
 * @property string $contact_person
 * @property string $name
 * @property string $banner
 * @property bool   $has_banner
 * @property string $alias
 */
class Tournaments extends \yii\db\ActiveRecord implements ImageInterface, UrlInterface
{

    public const IMAGES_BASE_PATH = '@web/img/tournament';

    public function getUrl(): string
    {
        return Url::to(['tournament/detail', 'alias' => $this->alias]);
    }

    public function getImageUrl(): string {
        return Yii::getAlias(self::IMAGES_BASE_PATH) . '/' . $this->img;
    }

    /**
     * @param int       $sportId
     * @param \DateTime $from
     * @param \DateTime $to
     *
     * @return array|\yii\db\ActiveRecord[]|Tournaments[]
     */
    public static function findByDates(int $sportId, \DateTime $from, \DateTime $to): array {
        return self::find()
            ->where('sport_id = :sport_id', ['sport_id' => $sportId])
            ->andWhere('ts_begin between :from and :to', ['from' => $from->format('Y-m-d H:i:s'), 'to' => $to->format('Y-m-d H:i:s')])
            ->andWhere('ts_end between :from and :to', ['from' => $from->format('Y-m-d H:i:s'), 'to' => $to->format('Y-m-d H:i:s')])
            ->all();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tournaments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sport_id', 'notify_before'], 'integer'],
            [['ts_created', 'ts_begin', 'ts_end'], 'safe'],
            [['description', 'img', 'contact_phone', 'contact_person', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sport_id' => 'Sport ID',
            'ts_created' => 'Ts Created',
            'ts_begin' => 'Ts Begin',
            'ts_end' => 'Ts End',
            'notify_before' => 'Notify Before',
            'description' => 'Description',
            'img' => 'Img',
            'contact_phone' => 'Contact Phone',
            'contact_person' => 'Contact Person',
            'name' => 'Name',
        ];
    }
}
