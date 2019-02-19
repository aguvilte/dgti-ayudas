<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Referentes;

/**
 * ReferentesSearch represents the model behind the search form about `app\models\Referentes`.
 */
class ReferentesSearch extends Referentes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_referente'], 'integer'],
            [['apeynom'], 'safe'],
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
        $query = Referentes::find();

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
