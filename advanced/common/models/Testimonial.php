<?php
declare(strict_types=1);

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\imagine\Image;
use yii\web\UploadedFile;

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
 * @property-read array|string[] $imageUrls
 * @property-read array[]|array $previewImageConfig
 * @property Project $project
 */
class Testimonial extends ActiveRecord
{
    public UploadedFile| string | null $uploadedFile = null;

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
            [['project_id', 'title', 'customerName', 'review', 'rating'], 'required'],
            [['project_id', 'customer_image_id', 'rating'], 'integer'],
            [['review'], 'string'],
            [['title', 'customerName'], 'string', 'max' => 255],
            [['customer_image_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['customer_image_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::class, 'targetAttribute' => ['project_id' => 'id']],
            [
                ['uploadedFile'],
                'file',
                'skipOnEmpty'   => true,
                'extensions'    => implode(",", Yii::$app->params['allowedUploadImageExtensions']),
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

    public function getImageUrls(): array
    {
        if ($this->customerImage) {
            return [$this->customerImage->getImageUrl()];
        }

        return [];
    }

    public function getPreviewImageConfig(): array
    {
        if ($this->customerImage) {
            return [['key' => $this->customerImage->id]];
        }

        return [];
    }

    public function uploadImageFile(): void
    {
        $this->uploadedFile = UploadedFile::getInstance($this, 'uploadedFile');
    }

    /**
     * @throws \Throwable
     */
    public function uploadImage(): bool
    {
        if ($this->uploadedFile === null) {
            return true;
        }

        $db = Yii::$app->db;
        $oldFilePath = '';

        // If there is an existing image, we will replace it
        if ($this->customerImage) {
            $file = $this->customerImage;
            $oldFilePath = Yii::getAlias('@webroot') . '/' . $file->getPathUrl();
        } else {
            $file = new File();
        }

        $db->beginTransaction();

        try {
            $file->name = uniqid() . '.' . $this->uploadedFile->extension;
            $file->path_url = Yii::$app->params['uploads']['testimonials'];
            $file->base_url = Yii::$app->urlManager->createAbsoluteUrl($file->path_url);
            $file->mime_type = $this->uploadedFile->type;
            $file->save();

            $this->customer_image_id = $file->id;
            $this->save();

            $thumbnail = Image::thumbnail($this->uploadedFile->tempName, null, 1080);

            if (!$thumbnail->save($file->getPathUrl()) ) {
                Yii::$app->session->setFlash(
                    'error',
                    Yii::t('app', 'Testimonail image upload fail.')
                );
                $db->transaction->rollBack();

                return false;
            }

            $db->transaction->commit();
            if($oldFilePath) {
                unlink($oldFilePath);
            }
            Yii::$app->session->setFlash('success', 'Testimonial created successfully.');

            return true;
        } catch (\Throwable $e) {
            Yii::$app->session->setFlash(
                'error',
                Yii::t('app', 'Testimonail image upload fail.') . "({$e->getMessage()})"
            );
            $db->transaction->rollBack();
            return false;
        }

    }

}
