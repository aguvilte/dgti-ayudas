<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Beneficiarios;

class BeneficiariosSearch extends Beneficiarios
{
    public $globalSearch;

    public function rules()
    {
        return [
            [['id_beneficiario', 'documento', 'estado'], 'integer'],
            [['apeynom','globalSearch', 'cuil', 'fecha_nacimiento', 'lugar_nacimiento', 'domicilio', 'telefono_celular', 'telefono_fijo', 'pdf_cuil', 'pdf_dni'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Beneficiarios::find()->where(['estado'=>1]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder' => [
                    'estado' => SORT_DESC,
                    'id_beneficiario' => SORT_DESC
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_beneficiario' => $this->id_beneficiario,
            'documento' => $this->documento,
        ]);

        $query->andFilterWhere(['like', 'apeynom', $this->apeynom])
            ->andFilterWhere(['like', 'cuil', $this->cuil])
            ->andFilterWhere(['like', 'fecha_nacimiento', $this->fecha_nacimiento])
            ->andFilterWhere(['like', 'lugar_nacimiento', $this->lugar_nacimiento])
            ->andFilterWhere(['like', 'domicilio', $this->domicilio])
            ->andFilterWhere(['like', 'documento', $this->documento]);

        return $dataProvider;
    }
}
