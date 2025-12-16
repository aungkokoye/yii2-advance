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
 * @property string $path_url
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
            [['name', 'base_url', 'mime_type', 'path_url'], 'required'],
            [['name', 'base_url', 'mime_type', 'path_url'], 'string', 'max' => 255],
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
            'path_url' => Yii::t('app', 'Path Url'),
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

    public function getImageUrl(): string
    {
        return rtrim($this->base_url, '/') . '/' . ltrim($this->name, '/');
    }

    public function getPathUrl(): string
    {
        return rtrim($this->path_url, '/') . '/' . ltrim($this->name, '/');
    }

    public function AfterDelete(): void
    {
        parent::afterDelete();

        $filePath = Yii::getAlias('@webroot') . '/' . $this->getPathUrl();
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
    }
}
