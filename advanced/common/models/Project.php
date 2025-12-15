<?php
declare(strict_types=1);

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $name
 * @property string $tech_stack
 * @property string $description
 * @property string $start_date
 * @property string|null $end_date
 *
 * @property ProjectImage[] $projectImages
 * @property Testimonial[] $testimonials
 */
class Project extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['end_date'], 'default', 'value' => null],
            [['name', 'tech_stack', 'description', 'start_date'], 'required'],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d'],
            [['tech_stack', 'description'], 'string'],
            [['start_date', 'end_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'tech_stack' => Yii::t('app', 'Tech Stack'),
            'description' => Yii::t('app', 'Description'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
        ];
    }

    /**
     * Gets query for [[ProjectImages]].
     *
     * @return ActiveQuery
     */
    public function getProjectImages(): ActiveQuery
    {
        return $this->hasMany(ProjectImage::class, ['project_id' => 'id']);
    }

    /**
     * Gets query for [[Testimonials]].
     *
     * @return ActiveQuery
     */
    public function getTestimonials(): ActiveQuery
    {
        return $this->hasMany(Testimonial::class, ['project_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectQuery(get_called_class());
    }

}
