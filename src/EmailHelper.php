<?php

namespace Drupal\symdrik_helper_tools;

use Drupal\Core\Mail\MailManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class EmailHelper
 *
 * @package Drupal\symdrik_helper_tools
 */
class EmailHelper {

  /**
   * Mail manage entity.
   *
   * @var \Drupal\Core\Mail\MailManager $mailManager
   */
  protected $mailManager;

  /**
   * EmailHelper constructor.
   *
   * @param \Drupal\Core\Mail\MailManager $mail_managger
   *   Mail manager to send notification mail.
   */
  public function __construct(MailManager $mail_managger) {
    $this->mailManager = $mail_managger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.mail')
    );
  }

  /**
   * Create a email properties (like subject, body, headers, etc.).
   *
   * @param array $params
   *   (optional) A keyed array of settings. Supported options are:
   *   - langcode: A language code.
   *   - user_id: a user uid entity.
   *   - to: Reception mail.
   *   - message: the content of email request.
   *   - subject of email request.
   *
   * @return bool
   */
  public function userEmailNotify($key, $to,$langcode, array $params) {
    try {
      $this->mailManager->mail('symdrik_helper_tools', $key, $to, $langcode, $params, NULL, TRUE);
      return TRUE;
    } catch (\Exception $e) {
      return FALSE;
    }
  }
}
