<?php

namespace Drupal\layout_builder_css\Form;

use Drupal;
use Drupal\Core\Entity\EntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class LayoutBuilderCssDisableForm.
 *
 * @package Drupal\layout_builder_css\Form
 */
class LayoutBuilderCssDisableForm extends EntityConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Disable @type: %label?', [
      '@type' => $this->entity->getEntityType()->getLabel(),
      '%label' => $this->entity->label(),
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->t('Disable @type: %label?', [
      '@type' => $this->entity->getEntityType()->getLabel(),
      '%label' => $this->entity->label(),
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    $type = $this->entity->getEntityType()->get('id');
    return new Url("entity.$type.collection");
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    /** @var \Drupal\Core\Config\Entity\ConfigEntityInterface $entity */
    $entity = $this->entity;
    $entity->disable()->save();

    Drupal::logger('layout_builder_css')->notice('%type asset %id disabled', [
      '%type' => $entity->get('entityTypeId'),
      '%id' => $entity->id,
    ]);

    parent::submitForm($form, $form_state);

    $form_state->setRedirectUrl($this->getCancelUrl());
  }

}
