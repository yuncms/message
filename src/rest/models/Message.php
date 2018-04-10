<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\message\rest\models;

use yuncms\rest\models\User;

/**
 * Class Message
 *
 * @author Tongle Xu <xutongle@gmail.com>
 * @since 3.0
 */
class Message extends \yuncms\message\models\Message
{
    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'parent',
            'status',
            'message',
            'user',
            'from',
            'created_at',
            'updated_at',
        ];
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
}