<?php
namespace  Drupal\layout_builder_css;

use Drupal\layout_builder_css\LayoutBuilderCssInterface;

/**
 * Class LayoutBuilderCssFileStorage.
 *
 * @package Drupal\layout_builder
 *
 * This asset file storage class implements a content-addressed file system
 * where each file is stored in a location like so:
 * public://layout_builder/[extension]/[name]-[md5].[extension]
 * Note that the name and extension-dir are redundant and purely for DX.
 *
 * Due to the nature of the config override system, the content of any asset
 * config entity can vary on external factory beyond our control, be it
 * language, domain, settings.php overrides or anything else. In other words,
 * any asset entity can map to an arbitrary number of actual assets.
 * Thus asset files are generated in AssetFileStorage::internalFileUri()
 * with a file name that is unique by their content, and only deleted on cache
 * flush.
 *
 */
final class LayoutBuilderCssFileStorage {
    /**
     * @var LayoutBuilderCssInterface
     */
    protected $layoutBuilder;


    /**
     * LayoutBuilderInterface constructor.
     *
     * @param LayoutBuilderCssInterface $layoutBuilder
     *
     */

    public function __construct(LayoutBuilderCssInterface $layoutBuilder)
    {
        $this->layoutBuilder = $layoutBuilder;
    }

    /**
     * Create file and return internal uri.
     *
     * @return string
     *   Internal file URI using public:// stream wrapper.
     */

    public function createFile()
    {

        $internal_uri = self::internalFileUri();
        if (!is_file($internal_uri)) {
            $directory = dirname($internal_uri);
            file_prepare_directory($directory, FILE_CREATE_DIRECTORY | FILE_MODIFY_PERMISSIONS);
            file_unmanaged_save_data($this->layoutBuilder->getCode(), $internal_uri, FILE_EXISTS_REPLACE);
        }
        return $internal_uri;
    }

    public function updateFile($internal_uri) {
       if (!is_file($internal_uri)) {
           $directory = dirname($internal_uri);
           file_prepare_directory($directory, FILE_CREATE_DIRECTORY | FILE_MODIFY_PERMISSIONS);
           file_unmanaged_save_data($this->layoutBuilder->getCode(), $internal_uri, FILE_EXISTS_REPLACE);
       }
    }
    /**
     * Delete files for an layoutBuilder_css.
     *
     * Yes, we can have multiple files for an layoutBuilder_css configuration, if we have
     * overrides.
     */
    public function deleteFile(){
        $pattern = $this->internalFileUri(TRUE);
        $paths = glob($pattern);
        foreach ($paths as $path) {
            file_unmanaged_delete($path);
        }
    }

    /**
     * Create internal file URI or pattern.
     *
     * @param bool $pattern
     *   Get Pattern instead of internal file URI.
     *
     * @return string
     *   File uri.
     */

    protected function internalFileUri($pattern = FALSE){
        $name = $this->layoutBuilder->id();
        $extension = $this->layoutBuilder->extension();
        $hash = $pattern ? '*' : md5($this->layoutBuilder->getCode());
        $all_layout_builder_directory = self::internalDirectoryUri();
        if ($pattern) {
            // glob() does not understand stream wrappers. Sigh.
            $all_layout_builder_directory = \Drupal::service('file_system')
                ->realpath($all_layout_builder_directory);
        }
        $internal_uri = "$all_layout_builder_directory/$extension/$name-$hash.$extension";
        return $internal_uri;

    }

    protected static function internalDirectoryUri() {
        return 'public://layout_builder_css';
    }
    /**
     * Delete all layout_builder files.
     * @see layout_builder_css_cache_flush
     */

    public static function deleteAllFiles() {

        $internal_uri = self::internalDirectoryUri();
        if (file_exists($internal_uri)) {
            file_unmanaged_delete_recursive($internal_uri);
        }
    }

    public function deleteFiles() {
        $pattern = $this->internalFileUri(TRUE);
        $paths = glob($pattern);
        foreach ($paths as $path) {
            file_unmanaged_delete($path);
        }
    }

}
