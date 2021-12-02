<?php


namespace App\Traits;

use Intervention\Image\Facades\Image;

trait FileUpload
{
    protected $upload_folder = 'uploads';
    protected $thumbnail_folder = 'thumbnails';
    protected $image_width = 500;
    protected $default_image = 'default.png';

    /**
     * Upload image with thumbnail (if $thumbnail is true ) by folder and file
     *
     * @param $folderName
     * @param $file
     * @param bool $thumbnail
     * @param bool $uploadWithThumbnail
     * @return string
     */
    public function upload($folderName,$file,$thumbnail = true,$uploadOrginalImage = true){
        if (!is_null($file)) {
            $this->checkFolder($folderName);
            $fileName = $folderName.'_'.$file->hashName();
            if ($uploadOrginalImage){
                Image::make($file)->save($this->generateFilePath($folderName,$fileName));
            }
            if ($thumbnail) {
                $this->_createThumbnail($file,$folderName,$fileName);
            }
            return $fileName;
        } else {
            return $this->default_image;
        }


    }

    /**
     * Delete image from server with thumbnails (if $thumbnail is true) by folder name and image name
     *
     * @param $folderName
     * @param $fileName
     * @param bool $thumbnail
     * @return $this
     */
    public function deleteImage($folderName,$fileName,$thumbnail = true)
    {
        if (file_exists($this->generateFilePath($folderName,$fileName))) {
            unlink($this->generateFilePath($folderName,$fileName));
            if ($thumbnail && file_exists($this->generateFilePath($folderName,$fileName,true))) {
                unlink($this->generateFilePath($folderName,$fileName,true));
            }
        }
        return $this;
    }

    /**
     *  Resize image for thumbnails
     * @param $file
     * @param $folderName
     * @param $fileName
     */
    private function _createThumbnail($file,$folderName,$fileName)
    {
        Image::make($file)->resize($this->image_width, null,function ($constraint){
            $constraint->aspectRatio();
        })->save($this->generateFilePath($folderName,$fileName,true));
    }

    /**
     *  Generate full upload path by folder name and file name
     *
     * @param $folderName
     * @param $fileName
     * @param bool $thumbnail
     * @return string
     */
    private function generateFilePath($folderName,$fileName,$thumbnail = false): string
    {
        return $thumbnail ?
            public_path($this->upload_folder.DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR.$this->thumbnail_folder.DIRECTORY_SEPARATOR.$fileName) :
            public_path($this->upload_folder.DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR.$fileName);
    }

    /**
     * @param $folderName
     * @param false $thumbnail
     * @return string
     */
    private function generateFolderPath($folderName,$thumbnail = false): string
    {
        return $thumbnail ?
            public_path($this->upload_folder.DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR.$this->thumbnail_folder) :
            public_path($this->upload_folder.DIRECTORY_SEPARATOR.$folderName);
    }

    /**
     * @param $folderName
     */
    private function checkFolder($folderName)
    {
        $folderDirection = $this->generateFolderPath($folderName);
        $this->makeFolder($folderDirection);
        $thumbnailFolderDirection = $this->generateFolderPath($folderName,true);
        $this->makeFolder($thumbnailFolderDirection);
    }

    /**
     * @param $path
     */
    private function makeFolder($path)
    {
        if (!file_exists($path)){
            mkdir($path,0767,true);
        }
    }
}
