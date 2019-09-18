<?php

namespace Drupal\extended_site_information\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class ExtendedSiteInformationRouteSubscriber extends RouteSubscriberBase
{
  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    if($route = $collection->get('system.site_information_settings')) {
      // Change form for the system.site_information_settings route to the custom
      // extended form we have created.
      $route->setDefault('_form', 'Drupal\extended_site_information\Form\ExtendedSiteInformationForm');
    }
  }
}
