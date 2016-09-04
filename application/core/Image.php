<?php

class Image
{

    public static $sizes;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public static function getSizes()
    {
        return self::$sizes;
    }

    /**
     * @param mixed $sizes
     */
    public static function setSizes($sizes)
    {
        foreach ($sizes as $key => $value) {
            self::$sizes[$key] = array(
                'width' => $value['width'],
                'height' => $value['height']
            );
        }
    }


    /**
     * @param $filename
     * @param $sizename
     * @return string
     */
    static function getImage($filename, $sizename)
    {
        if (isset(self::$sizes[$sizename])) {
            $width = self::$sizes[$sizename]['width'];
            $height = self::$sizes[$sizename]['height'];
            if (!file_exists(IMG_FOLDER . $filename) || !is_file(IMG_FOLDER . $filename) || empty($filename)) {
                $filename = 'no_image.png';
            }

            $info = pathinfo($filename);

            $extension = $info['extension'];

            $old_image = $filename;
            $new_image = 'cache/' . mb_substr($filename, 0, mb_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

            if (!file_exists(IMG_FOLDER . $new_image) || (filemtime(IMG_FOLDER . $old_image) > filemtime(IMG_FOLDER . $new_image))) {
                $path = '';

                $directories = explode('/', dirname(str_replace('../', '', $new_image)));

                foreach ($directories as $directory) {
                    $path = $path . '/' . $directory;

                    if (!file_exists(IMG_FOLDER . $path)) {
                        @mkdir(IMG_FOLDER . $path, 0777);
                    }
                }

                list($width_orig, $height_orig) = getimagesize(IMG_FOLDER . $old_image);

                if ($width_orig != $width || $height_orig != $height) {

                    $image = new Imagine\Gd\Imagine();
                    $image->open(IMG_FOLDER . $old_image)
                        ->thumbnail(
                            new Imagine\Image\Box($width, $height),
                            Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND)
                        ->save(IMG_FOLDER . $new_image);
                } else {
                    copy(IMG_FOLDER . $old_image, IMG_FOLDER . $new_image);
                }
            }


            return IMG_FOLDER_URL . $new_image;
        } else {
            return IMG_FOLDER_URL . '/no_image.png';
        }
    }
}