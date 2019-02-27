<?php

namespace app\models;

use Yii;

class Areas extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'areas';
    }

    public function rules()
    {
        return [
            [['estado'], 'integer'],
            [['nombre', 'estado'], 'required'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_area' => 'Id Area',
            'nombre' => 'Nombre',
        ];
    }
}
