<?php
declare(strict_types=1);

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string $name
 * @property string $base_url
 * @property string $mime_type
 *
 * @property ProjectImage[] $projectImages
 * @property Testimonial[] $testimonials
 */
class File extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'base_url', 'mime_type'], 'required'],
            [['name', 'base_url', 'mime_type'], 'string', 'max' => 255],
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
            'base_url' => Yii::t('app', 'Base Url'),
            'mime_type' => Yii::t('app', 'Mime Type'),
        ];
    }

    /**
     * Gets query for [[ProjectImages]].
     *
     * @return ActiveQuery
     */
    public function getProjectImages(): ActiveQuery
    {
        return $this->hasMany(ProjectImage::class, ['file_id' => 'id']);
    }

    /**
     * Gets query for [[Testimonials]].
     *
     * @return ActiveQuery
     */
    public function getTestimonials(): ActiveQuery
    {
        return $this->hasMany(Testimonial::class, ['customer_image_id' => 'id']);
    }

}
