<?php

namespace Drupal\layout_builder_css\Form;

use Drupal\Core\Form\FormStateInterface;

/**
 * Class LayoutBuilderCssForm.
 *
 * @package Drupal\asset_injector\Form
 */
class LayoutBuilderCssForm extends LayoutBuilderCssFormBase {
    /**
     * {@inheritdoc}
     */
    public function form(array $form, FormStateInterface $form_state) {
        $form = parent::form($form, $form_state);

        $form['code']['#attributes']['data-ace-mode'] = 'css';
        return $form;
    }

}
