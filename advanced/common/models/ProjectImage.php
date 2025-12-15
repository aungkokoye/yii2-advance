<?php
declare(strict_types=1);

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "project_image".
 *
 * @property int $id
 * @property int $project_id
 * @property int $file_id
 *
 * @property File $file
 * @property Project $project
 */
class ProjectImage extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'project_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['project_id', 'file_id'], 'required'],
            [['project_id', 'file_id'], 'integer'],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['file_id' => 'id']],
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
            'file_id' => Yii::t('app', 'File ID'),
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return ActiveQuery
     */
    public function getFile(): ActiveQuery
    {
        return $this->hasOne(File::class, ['id' => 'file_id']);
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
