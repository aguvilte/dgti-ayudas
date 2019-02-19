<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "referentes".
 *
 * @property integer $id_referente
 * @property string $apeynom
 */
class Referentes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'referentes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['apeynom'], 'required'],
            [['apeynom'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_referente' => 'Id Referente',
            'apeynom' => 'Apeynom',
        ];
    }
}
