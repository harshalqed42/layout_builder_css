<?php

namespace Drupal\layout_builder_css\Entity;

use Drupal\layout_builder_css\LayoutBuilderCssInterface;
use Drupal\layout_builder_css\LayoutBuilderCssFileStorage;
use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityWithPluginCollectionInterface;
use Drupal\Core\Condition\ConditionPluginCollection;

/**
 * Class AssetI: LayoutBuilderCssBase asset injector class.
 *
 * @package Drupal\layout_builder_css\LayoutBuilderCssBase.
 */
abstract class LayoutBuilderCssBase extends ConfigEntityBase implements LayoutBuilderCssInterface, EntityWithPluginCollectionInterface {

    /**
     * The Asset Injector ID.
     *
     * @var string
     */
    public $id;

    /**
     * The Js Injector label.
     *
     * @var string
     */
    public $label;

    /**
     * The code of the asset.
     *
     * @var string
     */
    public $code;

    /**
     * Node type to apply asset.
     *
     * @var string
     * @deprecated
     */
    public $nodeType;

    /**
     * The available contexts for this asset and its conditions conditions.
     *
     * @var array
     */
    protected $contexts = [];


    /**
     * {@inheritdoc}
     */
    public function __construct(array $values, $entity_type) {
        parent::__construct($values, $entity_type);

    }

    /**
     * {@inheritdoc}
     */
    public function libraryNameSuffix() {
        $extension = $this->extension();
        return "$extension/$this->id";
    }

    /**
     * {@inheritdoc}
     */
    abstract public function libraryInfo();

    /**
     * {@inheritdoc}
     */
    abstract public function extension();


    /**
     * {@inheritdoc}
     */
    public function internalFileUri() {
        $storage = new LayoutBuilderCssFileStorage($this);
        return $storage->createFile();
    }

    /**
     * Get file path relative to drupal root to use in library info.
     *
     * @return string
     *   File path relative to drupal root, with leading slash.
     */
    protected function filePathRelativeToDrupalRoot() {
        // @todo See if we can simplify this via file_url_transform_relative().
        $path = parse_url(file_create_url($this->internalFileUri()), PHP_URL_PATH);
        $path = str_replace(base_path(), '/', $path);
        return $path;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * On delete delete this asset's file(s).
     */
    public function delete() {
        $storage = new LayoutBuilderCssFileStorage($this);
        $storage->deleteFiles();
        parent::delete();
    }

    /**
     * On update delete this asset's file(s), will be recreated later.
     */
    public function preSave(EntityStorageInterface $storage) {
        $original_id = $this->getOriginalId();
        if ($original_id) {
            $original = $storage->loadUnchanged($original_id);
            // This happens to fail on config import.
            if ($original instanceof LayoutBuilderCssInterface) {
                $layout_builder_css_storage = new LayoutBuilderCssFileStorage($original);
                $layout_builder_css_storage->deleteFiles();//($component->get('layout_builder_css_internal_uri'));
            }
        }
        parent::preSave($storage);
    }

}
