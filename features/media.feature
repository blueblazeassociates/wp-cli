Feature: Manage WordPress attachments
  
  Background:
    Given a WP install

  Scenario: Regenerate all images while none exists
    When I try `wp media regenerate --yes`
    Then STDERR should contain:
      """
      No images found.
      """

  Scenario: Import image from remote URL
    When I run `wp media import 'http://s.w.org/about/images/logos/codeispoetry-rgb.png' --post_id=1`
    Then STDOUT should contain:
      """
      Success: Imported file http://s.w.org/about/images/logos/codeispoetry-rgb.png
      """

  Scenario: Fail to import missing image
    When I try `wp media import gobbledygook.png`
    Then STDERR should contain:
      """
      Unable to import file gobbledygook.png. Reason: File doesn't exist.
      """

  Scenario: Import a file as attachment from a local image
    Given download:
      | path                        | url                                                               |
      | {CACHE_DIR}/large-image.jpg | http://s.w.org/about/images/desktops/wp-dark-hi-2880x1800.png     |

    When I run `wp media import {CACHE_DIR}/large-image.jpg --post_id=1 --featured_image`
    Then STDOUT should contain:
      """
      Success: Imported file
      """
    And STDOUT should contain:
      """
      and attached to post 1 as featured image
      """
    And the {CACHE_DIR}/large-image.jpg file should exist
