<?php
declare(strict_types=1);

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property int|null $is_published
 * @property string $slug
 * @property string $created_at
 * @property string $updated_at
 */
class Post extends ActiveRecord
{

    public function behaviors(): array
    {
        return [
            [
                'class'                 => TimestampBehavior::class,
                'createdAtAttribute'    => 'created_at',
                'updatedAtAttribute'    => 'updated_at',
                'value'                 => new Expression('NOW()'),
            ],
            [
                'class'         => SluggableBehavior::class,
                'attribute'     => 'title',
                'slugAttribute' => 'slug',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['is_published'], 'default', 'value' => null],
            [['title', 'body', 'slug'], 'required'],
            [['body'], 'string'],
            [['is_published'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'body' => Yii::t('app', 'Body'),
            'is_published' => Yii::t('app', 'Is Published'),
            'slug' => Yii::t('app', 'Slug'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PostQuery the active query used by this AR class.
     */
    public static function find(): PostQuery
    {
        return new PostQuery(get_called_class());
    }

}
