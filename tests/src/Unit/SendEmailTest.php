<?php
/**
 * @file
 * Contains \Drupal\Tests\symdrik_helper_tools\Unit\SendEmailTest.
 */
namespace Drupal\Tests\symdrik_helper_tools\Unit;

use Drupal\symdrik_helper_tools\EmailHelper;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;


/**
 * Unit Tests for send email to user.
 *
 *
 * @ingroup symdrik_helper_email
 *
 * @group symdrik_helper_email
 *
 * @coversDefaultClass \Drupal\symdrik_helper_tools\EmailHelper
 */
class SendEmailTest extends UnitTestCase {

  /**
   * Mail manage entity.
   *
   * @var \Drupal\Core\Mail\MailManager $mailManager
   */
  protected $mailManager;

  /**
   * Translate markup.
   *
   * @var \Drupal\Core\StringTranslation\TranslationInterface $translateMarkup
   */
  protected $translateMarkup;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();
    $this->translateMarkup = $this->getMockBuilder('\Drupal\Core\StringTranslation\TranslationInterface')
      ->disableOriginalConstructor()
      ->getMock();
    $this->mailManager = $this->getMockBuilder('\Drupal\Core\Mail\MailManager')
      ->disableOriginalConstructor()
      ->getMock();
    $container = new ContainerBuilder();
    $mailManager = $this->prophesize(\Drupal\Core\Mail\MailManagerInterface::class);
    $container->set('plugin.manager.mail', $mailManager->reveal());
    \Drupal::setContainer($container);
  }

  /**
   * Tests the userEmailNotify method.
   *
   * @covers ::userEmailNotify
   *
   */
  public function testUserEmailNotify() {
    $emailHrlper = new EmailHelper($this->mailManager);
    $optionsToSendMail = [
      'user_id' => 2,
      'langcode' => "en",
      'to' => "marouan.ben.mansour@gmail.com",
      'subject' => $this->translateMarkup->translate('Creation your account astore'),
      'message' => 'Hello Marouan',
      'enable' => TRUE,
    ];
    $msg = $emailHrlper->userEmailNotify($optionsToSendMail['user_id'],$optionsToSendMail['to'],$optionsToSendMail['langcode'],$optionsToSendMail);
    $this->assertEquals(TRUE, $msg);
  }
}
