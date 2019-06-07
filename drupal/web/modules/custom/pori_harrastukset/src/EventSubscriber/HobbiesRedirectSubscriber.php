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
   * Redirects the hobbies calendar to url with one week window of date start/end.
   */
  public function dateRangeRedirect(GetResponseEvent $event) {

    $params = \Drupal::request()->query->all();
    $current_url = Url::fromRoute('<current>');
    $url = $current_url->getInternalPath();
    $urls_to_redirect = [
      'node',
      'harrastukset'
    ];
    if (in_array($url, $urls_to_redirect) && empty($params)) {
      global $base_url;
      $days = 5;
      $start = strtotime('today midnight');
      $end = strtotime('+' . $days . ' day', $start);

      // The start and end parameters, timestamp as normal
      // but extra digits for searchkit..
      $start = 'event_date_from=' . (string) $start . '000';
      $end = 'event_date_to=' . (string) $end . '999';

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
