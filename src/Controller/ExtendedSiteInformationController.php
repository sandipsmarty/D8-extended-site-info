<?php

namespace Drupal\extended_site_information\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
Use Drupal\Core\Routing;
use Drupal\Core\Access\AccessResult;

/**
 * Class ExtendedSiteInformationController.
 */
class ExtendedSiteInformationController extends ControllerBase {
  /**
   * Checks access for this controller.
   *
   * @param string $sitekey
   *   The site API key.
   * @param Object $node
   *   The node object.
   *
   * @return boolean
   *   Return TRUE/FALSE.
   */
  public function access($sitekey, NodeInterface $node) {
    $config = \Drupal::config('system.site');
    if ($sitekey == $config->get('siteapikey') && !empty($node) && $node->getType() == 'page') {
      return AccessResult::allowed();
    }

    // Return 403 Access Denied page. 
    return AccessResult::forbidden();
  }

  /**
   * Converting Node to JSON format.
   *
   * @param string $sitekey
   *   The site API key.
   * @param Object $node
   *   The node object.
   *
   * @return string
   *   Return JSON string.
   */

  public function nodeToJson($sitekey, NodeInterface $node) {
    $json_array['data'][] = array(
      'type' => $node->get('type')->target_id,
      'id' => $node->get('nid')->value,
      'attributes' => array(
        'title' =>  $node->get('title')->value,
        'content' => $node->get('body')->value,
      ),
    );

    return new JsonResponse($json_array);
  }
}
