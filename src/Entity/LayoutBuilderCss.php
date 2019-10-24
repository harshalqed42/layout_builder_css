<?php

namespace Drupal\layout_builder_css\Entity;

/**
 * Defines the Css Injector entity.
 *
 * @ConfigEntityType(
 *   id = "layout_builder_css_css",
 *   label = @Translation("Css Injector"),
 *   list_cache_tags = { "library_info" },
 *   handlers = {
 *     "access" = "Drupal\layout_builder_css\LayoutBuilderCssAccessControlHandler",
 *     "list_builder" = "Drupal\layout_builder_css\LayoutBuilderCssListBuilder",
 *     "form" = {
 *       "add" = "Drupal\layout_builder_css\Form\LayoutBuilderCssForm",
 *       "edit" = "Drupal\layout_builder_css\Form\LayoutBuilderCssForm",
 *       "delete" = "Drupal\layout_builder_css\Form\LayoutBuilderCssDeleteForm",
 *       "enable" = "Drupal\layout_builder_css\Form\LayoutBuilderCssEnableForm",
 *       "disable" = "Drupal\layout_builder_css\Form\LayoutBuilderCssDisableForm",
 *       "duplicate" = "Drupal\layout_builder_css\Form\LayoutBuilderCssDuplicateForm",
 *     },
 *   },
 *   config_prefix = "css",
 *   admin_permission = "administer css layout builder",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/config/development/layout-builder-css/css/{layout_builder_css_css}",
 *     "edit-form" = "/admin/config/development/layout-builder-css/{layout_builder_css_css}",
 *     "delete-form" = "/admin/config/development/layout-builder-css/css/{layout_builder_css_css}/delete",
 *     "enable" = "/admin/config/development/layout-builder-css/css/{layout_builder_css_css}/enable",
 *     "disable" = "/admin/config/development/layout-builder-css/css/{layout_builder_css_css}/disable",
 *   }
 * )
 */

class LayoutBuilderCss extends LayoutBuilderCssBase {

    /**
     * Gets the file extension of the asset.
     *
     * @return string
     *   Css extension.
     */
    public function extension() {
        return 'css';
    }

    public function getPluginCollections() {
    return [];
    }

    /**
     * {@inheritdoc}
     */
    public function libraryInfo() {
        $path = $this->filePathRelativeToDrupalRoot();
        $library_info = [
            'css' => [
                'theme' => [
                    $path => [
                        'weight' => 0,
                    ],
                ],
            ],
        ];
        return $library_info;
    }

}





