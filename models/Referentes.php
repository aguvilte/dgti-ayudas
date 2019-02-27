<?php

namespace app\models;

use Yii;

class Referentes extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'referentes';
    }

    public function rules()
    {
        return [
            [['estado'], 'integer'],
            [['apeynom', 'estado'], 'required'],
            [['apeynom'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_referente' => 'Id Referente',
            'apeynom' => 'Apeynom',
        ];
    }
}
