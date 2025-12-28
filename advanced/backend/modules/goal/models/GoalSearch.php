<?php
declare(strict_types=1);

namespace backend\modules\goal\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Goal;

/**
 * GoalSearch represents the model behind the search form of `common\models\Goal`.
 */
class GoalSearch extends Goal
{
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['name', 'created_at', 'updated_at', 'created_by'], 'safe'],
        ];
    }

    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search(array $params, ?string $formName = null): ActiveDataProvider
    {
        $query = Goal::find()->joinWith('createdBy');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'goal.id' => $this->id,
            'goal.created_at' => $this->created_at,
            'goal.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'goal.name', $this->name]);
        $query->andFilterWhere(['like', 'user.username', $this->created_by]);

        return $dataProvider;
    }
}
