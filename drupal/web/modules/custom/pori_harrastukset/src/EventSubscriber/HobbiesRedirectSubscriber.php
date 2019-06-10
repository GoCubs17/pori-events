<?php

namespace Drupal\pori_harrastukset\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Drupal\Core\Url;

/**
 * Class HobbiesRedirectSubscriber.
 */
class HobbiesRedirectSubscriber implements EventSubscriberInterface {

  /**
   * Add daterange query parameters for default calendar view requests.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *   ResponseEvent.
   */
  public function dateRangeRedirect(GetResponseEvent $event) {

    $url = Url::fromRoute('<current>')->getInternalPath();
    $days = 5;

    /* @var $path_matcher \Drupal\Core\Path\PathMatcher */
    $path_matcher = \Drupal::service('path.matcher');

    $do_redirect = ($path_matcher->isFrontpage() || $path_matcher->matchPath('harrastukset', $url)) ? TRUE : FALSE;

    if (empty(\Drupal::request()->query->all()) && $do_redirect) {
      global $base_url;
      $today = strtotime('today midnight');

      // Use millisecond dates like
      // \Drupal\events2elastic\Plugin\Normalizer\NodeNormalizer does..
      $start = 'event_date_from=' . date('U000', $today);
      $end = 'event_date_to=' . date('U000', strtotime('+5 day', $today));

      // Rewrite to empty url if homepage.
      $url = ($path_matcher->isFrontpage()) ? '' : $url;

      // Let user know about the time window default.
      // @todo: This is a dirty hack - what we need is to bypass cache....
      drupal_set_message(t('Search filtered to next @days days', ['@days' => $days]));

      $response = new RedirectResponse($base_url . '/' . $url . '?' . $start . '&' . $end);
      $response->send();
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['dateRangeRedirect', 30];

    return $events;
  }

}
