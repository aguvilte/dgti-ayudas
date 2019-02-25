<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AyudasExpedientes;

/**
 * AyudasExpedientesSearch represents the model behind the search form about `app\models\AyudasExpedientes`.
 */
class AyudasExpedientesSearch extends AyudasExpedientes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_ayuda', 'id_expediente'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AyudasExpedientes::find();

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
            'id' => $this->id,
            'id_ayuda' => $this->id_ayuda,
            'id_expediente' => $this->id_expediente,
        ]);

        return $dataProvider;
    }
}
