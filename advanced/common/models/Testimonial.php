<?php
declare(strict_types=1);

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "testimonial".
 *
 * @property int $id
 * @property int $project_id
 * @property int $customer_image_id
 * @property string $title
 * @property string $customerName
 * @property string $review
 * @property int $rating
 *
 * @property File $customerImage
 * @property Project $project
 */
class Testimonial extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'testimonial';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['project_id', 'customer_image_id', 'title', 'customerName', 'review', 'rating'], 'required'],
            [['project_id', 'customer_image_id', 'rating'], 'integer'],
            [['review'], 'string'],
            [['title', 'customerName'], 'string', 'max' => 255],
            [['customer_image_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['customer_image_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::class, 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_id' => Yii::t('app', 'Project ID'),
            'customer_image_id' => Yii::t('app', 'Customer Image ID'),
            'title' => Yii::t('app', 'Title'),
            'customerName' => Yii::t('app', 'Customer Name'),
            'review' => Yii::t('app', 'Review'),
            'rating' => Yii::t('app', 'Rating'),
        ];
    }

    /**
     * Gets query for [[CustomerImage]].
     *
     * @return ActiveQuery
     */
    public function getCustomerImage(): ActiveQuery
    {
        return $this->hasOne(File::class, ['id' => 'customer_image_id']);
    }

    /**
     * Gets query for [[Project]].
     *
     * @return ActiveQuery
     */
    public function getProject(): ActiveQuery
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

}
