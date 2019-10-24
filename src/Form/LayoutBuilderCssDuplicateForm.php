<?php

namespace Drupal\layout_builder_css\Form;

use Drupal\Core\Form\FormStateInterface;

/**
 * Class LayoutBuilderCssDuplicateForm.
 *
 * @package Drupal\layout_builder_css\Form
 */
class LayoutBuilderCssDuplicateForm extends LayoutBuilderCssForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\asset_injector\Entity\AssetInjectorJs $entity */
    $entity = $this->entity->createDuplicate();
    $entity->label = $this->t('Duplicate of @label', ['@label' => $this->entity->label()]);
    $this->entity = $entity;
    return parent::form($form, $form_state);
  }

}
