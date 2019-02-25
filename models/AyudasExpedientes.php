<?php

namespace app\models;

use Yii;

class AyudasExpedientes extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ayudas_expedientes';
    }

    public function rules()
    {
        return [
            [['id_ayuda', 'id_expediente'], 'required'],
            [['id_ayuda', 'id_expediente'], 'integer'],
            [['id_ayuda'], 'exist', 'skipOnError' => true, 'targetClass' => Ayudas::className(), 'targetAttribute' => ['id_ayuda' => 'id_ayuda']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ayuda' => 'Id Ayuda',
            'id_expediente' => 'Id Expediente',
        ];
    }

    public function getAyudas()
    {
        return $this->hasOne(Ayudas::className(), ['id_ayuda' => 'id_ayuda']);
    }
}
