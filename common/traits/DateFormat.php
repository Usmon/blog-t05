<?php

namespace common\traits;

use Yii;
use yii\db\Expression;

/**
 * Trait for Date and Time
 */
trait DateFormat
{
    /**
     * Expression
     * 
     * @return string
     */
    public static function nowExpression()
    {
        return new Expression('NOW()');
    }
}