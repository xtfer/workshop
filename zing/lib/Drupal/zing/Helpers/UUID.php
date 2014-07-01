<?php
/**
 * @file
 * Contains a UUID Helper
 *
 * @copyright Copyright(c) 2014 Christopher Skene
 * @license GPL v2 http://www.fsf.org/licensing/licenses/gpl.html
 * @author Chris Skene chris at xtfer dot com
 */

class UUID {

  /**
   * Create a UUID.
   *
   * @return string
   *   A v4 UUID.
   */
  static public function create() {
    if (function_exists('openssl_random_pseudo_bytes')) {
      $data = openssl_random_pseudo_bytes(16);
    }
    else {
      $data = file_get_contents('/dev/urandom', NULL, NULL, 0, 16);
    }

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
  }
}
