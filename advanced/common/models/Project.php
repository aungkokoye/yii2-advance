<?php
declare(strict_types=1);

namespace common\models;

use yii\imagine\Image;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\web\UploadedFile;

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
 * @property-read array $imageUrls
 * @property-read array $previewImageConfig
 * @property Testimonial[] $testimonials
 */
class Project extends ActiveRecord
{
    /**
     * @var UploadedFile[]|null
     */
    public $uploadedFiles;

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
            [
                ['uploadedFiles'],
                'file',
                'skipOnEmpty'   => true,
                'extensions'    => implode(",", Yii::$app->params['allowedUploadImageExtensions']),
                'maxFiles'      => Yii::$app->params['maxUploadFiles'],
                'maxSize'       => Yii::$app->params['maxUploadFileSize'],
            ],
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

    /**
     * @throws \Throwable
     */
    public function uploadImages(): void
    {
        if (empty($this->uploadedFiles)) {
            return;
        }

        foreach ($this->uploadedFiles as $uploadedFile) {
            Yii::$app->db->transaction(function (Connection $db) use($uploadedFile) {
                $file = new File();
                $file->name = uniqid() . '.' . $uploadedFile->extension;
                $file->path_url = Yii::$app->params['uploads']['projects'];
                $file->base_url = Yii::$app->urlManager->createAbsoluteUrl($file->path_url);
                $file->mime_type = $uploadedFile->type;
                $file->save();

                $projectImage = new ProjectImage();
                $projectImage->project_id = $this->id;
                $projectImage->file_id = $file->id;
                $projectImage->save();

                $thumbnail = Image::thumbnail($uploadedFile->tempName, null, 1080);

                if (!$thumbnail->save($file->getPathUrl())) {
                    $db->transaction->rollBack();
                }
            });
        }
    }

    public function hasImage(): bool
    {
        return count($this->projectImages) > 0;
    }

    public function getImageUrls(): array
    {
        $urls = [];
        foreach ($this->projectImages as $image) {
            $urls[] = $image->file->getImageUrl();
        }

        return $urls;
    }

    public function getPreviewImageConfig(): array {
        $config = [];
        foreach ($this->projectImages as $image) {
            $config[] = ['key' => $image->id];
        }

        return $config;
    }

    public function uploadImageFiles(): void
    {
        $this->uploadedFiles = UploadedFile::getInstances($this, 'uploadedFiles');
    }
}
