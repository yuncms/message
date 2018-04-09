<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\message\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yuncms\db\ActiveRecord;
use yuncms\user\models\User;

/**
 * Class Message
 * @property int $id
 * @property int $user_id
 * @property int $from_id
 * @property int $parent
 * @property string $message
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Message $lastMessage
 * @property User $user
 * @property Message[] $Messages
 * @package yuncms\user\models
 */
class Message extends ActiveRecord
{
    const STATUS_NEW = false;
    const STATUS_READ = true;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class
            ],
            'blameable' => [
                'class' => BlameableBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'from_id',
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'message'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['message'], 'string', 'max' => 750],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => static::class, 'targetAttribute' => ['parent' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['status'], 'default', 'value' => static::STATUS_NEW],
            ['status', 'in', 'range' => [static::STATUS_NEW, static::STATUS_READ], 'message' => Yii::t('yuncms/message', 'Incorrect status')],
        ];
    }

    /**
     * 设置已读
     * @return int
     */
    public function setRead()
    {
        return $this->updateAttributes(['status' => static::STATUS_READ]);
    }

    /**
     * 返回父短消息
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(static::class, ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom()
    {
        return $this->hasOne(User::class, ['id' => 'from_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * 收件人是不是我自己
     * @return bool
     */
    public function isRead()
    {
        return $this->status == static::STATUS_READ;
    }

    /**
     * 收件人是不是我自己
     * @return bool
     */
    public function isRecipient()
    {
        return Yii::$app->user->id == $this->user_id;
    }

    /**
     * 返回子短消息
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(static::class, ['parent' => 'id']);
    }

    /**
     * 获取会话最后一行
     * @return $this|array|null|ActiveRecord
     */
    public function getLastMessage()
    {
        if (($message = $this->getMessages()->orderBy(['created_at' => SORT_DESC])->limit(1)->one()) != null) {
            return $message;
        }
        return $this;
    }
}