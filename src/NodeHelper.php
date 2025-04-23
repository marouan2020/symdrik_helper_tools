<?php
namespace  Drupal\symdrik_helper_tools;

use Drupal\node\Entity\Node;

/**
 * Class NodeHelper
 *
 * @package Drupal\symdrik_helper_tools
 */
class NodeHelper {

  /**
   * Insert a node.
   *
   * @param array $properties
   *   Exclusive fields title, status, type.
   * @param array $fields
   *   Fields content type to add it.
   *
   * @return \Drupal\node\Entity\Node $node
   *   Result is a Entity node.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function insertNode($properties, $fields = []) {
    $node = Node::create($properties);
    foreach($fields as $fieldName => $fieldValue) {
      $node->set($fieldName, $fieldValue);
    }
    //$node->enforceIsNew();
    $node->save();
    return $node;
  }

  /**
   * Retrive a node using fields.
   *
   * @param string $type
   *   Machine name of type content.
   * @param array $fields
   *   Fields and values to fetch.
   *
   * @return \Drupal\node\Entity\Node|null
   *   Result can be Entity node or null.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function getNodeByFields($type, $fields=[]) {
    $query = \Drupal::entityQuery('node')
      ->condition('type', $type)
      ->accessCheck(FALSE);
    foreach($fields as $fieldName => $fieldValue) {
      $query->condition($fieldName, $fieldValue);
    }
    $nids = $query->execute();
    if (empty($fields)) {
      return $nids;
    }
    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($nids);
    $node = reset($nodes);
    return !empty($node) ? $node : null;
  }

  /**
   * Update node.
   *
   * @param \Drupal\node\Entity\Node $node
   *   Entity node.
   *
   * @param $properties
   *   Exclusive fields title, status, type.
   * @param array $fields
   *   Fields and values for updating.
   *
   * @return \Drupal\node\Entity\Node
   *   Result its a entity node.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function updateNode(Node $node, $properties, $fields = []) {
    foreach($properties as $propertyName => $propertyValue) {
      $node->set($propertyName, $propertyValue);
    }
    foreach($fields as $fieldName => $fieldValue) {
      $node->set($fieldName, $fieldValue);
    }
    $node->save();
    return $node;
  }

  public function getNodeById($nodeID){
    $node = \Drupal::entityTypeManager()->getStorage('node')->load($nodeID);
    return $node;
  }
}
