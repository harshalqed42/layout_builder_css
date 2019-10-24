<?php

namespace Drupal\layout_builder_css;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityHandlerInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Plugin\Context\ContextHandlerInterface;
use Drupal\Core\Plugin\Context\ContextRepositoryInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the access control handler for the shortcut entity type.
 *
 * @see \Drupal\layout_builder_css\Entity\LayoutBuilderCssAccessControlHandler
 */
class LayoutBuilderCssAccessControlHandler extends EntityAccessControlHandler implements EntityHandlerInterface {
    /**
     * Constructs a LayoutBuilderCssAccessControlHandler object.
     *
     * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
     *   The entity type definition.
     *
     */

    public function __construct(EntityTypeInterface $entity_type, ContextHandlerInterface $context_handler, ContextRepositoryInterface $context_repository) {
        parent::__construct($entity_type);
        $this->contextHandler = $context_handler;
        $this->contextRepository = $context_repository;
    }
    /**
     * {@inheritdoc}
     */
    public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
      return new static(
        $entity_type,
        $container->get('context.handler'),
        $container->get('context.repository')
      );
    }
}
