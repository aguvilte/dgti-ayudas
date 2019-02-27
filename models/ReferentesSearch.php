<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Referentes;

class ReferentesSearch extends Referentes
{
    public function rules()
    {
        return [
            [['id_referente', 'estado'], 'integer'],
            [['apeynom'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Referentes::find()->where(['estado' => '1']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_referente' => $this->id_referente,
        ]);

        $query->andFilterWhere(['like', 'apeynom', $this->apeynom]);

        return $dataProvider;
    }
}
