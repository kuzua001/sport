<?php

namespace common\models\subscription;

use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Class Subscription
 * @package common\models\subscription
 * @property $email string
 * @property $type integer
 * @property $ts_created integer
 */
class Subscription extends ActiveRecord {
    public const TYPE_INVESTOR = 1;
    public const TYPE_STARTUP = 2;
    public const TYPE_SERVICE_PROVIDER = 3;
    public const TYPE_EXPERT = 4;

    public static function tableName(): string {
        return 'data.subscriptions';
    }

    public static function create(string $email, int $type): self {
        $subscription = new self();
        $subscription->email = $email;
        $subscription->type = $type;
        $subscription->ts_created = new Expression('now()');
        $subscription->save(false);

        return $subscription;
    }
}