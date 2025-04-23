<?php
/**
 * @file
 * Contains \Drupal\Tests\symdrik_helper_user\Unit\UserPassResetUrlTest.
 */
namespace Drupal\Tests\symdrik_helper_user\Unit;

use Drupal\symdrik_helper_tools\UserHelper;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Unit Tests for generate a url forget password.
 *
 *
 * @ingroup symdrik_helper_user
 *
 * @group symdrik_helper_user
 *
 * @coversDefaultClass \Drupal\symdrik_helper_tools\UserHelper
 */
class UserPassResetUrlTest extends UnitTestCase {

  protected $helperUser;
  /**
   * {@inheritdoc}
   */
  public function setUp() :void {
    parent::setUp();
    $this->helperUser =  new \Drupal\symdrik_helper_tools\UserHelper("marouan.ben.mansour@gmail.com");
    $container = new ContainerBuilder();
    \Drupal::setContainer($container);
  }

  /**
   * Tests the userPassResetUrl method.
   *
   * @covers ::userPassResetUrl
   *
   */
  public function testUserPassResetUrl() {
    $optionsToSendMail = [
      'user_id' => 2,
      'langcode' => "en",
      'enable' => TRUE,
    ];
    $generatedUrl = $this->helperUser->userPassResetUrl($optionsToSendMail);
    $this->assertNotEmpty($generatedUrl, "me key url");
  }
}
