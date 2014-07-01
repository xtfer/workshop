<?php
/**
 * @file
 * Contains a BaseHandler Handler
 *
 * @copyright Copyright(c) 2014 Christopher Skene
 * @license GPL v2 http://www.fsf.org/licensing/licenses/gpl.html
 * @author Chris Skene chris at xtfer dot com
 */

namespace Drupal\zing\Handler;

use Drupal\zing\Element\Element;

/**
 * A base handler.
 */
class BaseHandler
  implements HandlerInterface {

  /**
   * The form array.
   *
   * @var array
   */
  protected $renderArray = array();

  /**
   * Constructor.
   */
  public function __construct() {
    $this->renderArray = array();
  }

  /**
   * Add a new element.
   *
   * @param string|null $type
   *   (optional) The type of element to set. This should be returnable by
   *   validElementTypes().
   * @param string $name
   *   (optional) The name of the element. If not provided, one will be
   *   generated automatically (which may not be desirable if you plan to access
   *   this form value in the future).
   *
   * @return Element|\Drupal\zing\Element\FormElement
   *   An Element object, for chaining.
   */
  public function addElement($type = NULL, $name = NULL) {
    if (empty($name) && module_exists('uuid')) {
      $name = uniqid();
    }

    if (!empty($name)) {
      if (in_array($type, $this->validElementTypes())) {
        $this->renderArray[$name] = $this->newElement($name);
        if (!empty($type)) {
          $this->getElement($name)->setType($type);
        }
      }
      else {
        watchdog('zing', 'Invalid element %type used.', array(
          '%type' => $type,
        ));
      }
    }

    return $this->getElement($name);
  }

  /**
   * Create a new element.
   *
   * @param string $name
   *   Name of the element.
   *
   * @return Element
   *   The element.
   */
  protected function newElement($name) {
    return new Element($name, $this);
  }

  /**
   * Get an element to work with.
   *
   * @param string $name
   *   Name of the element to return.
   *
   * @return Element|\Drupal\zing\Element\FormElement
   *   The element.
   */
  public function getElement($name) {
    if (isset($this->renderArray[$name])) {
      return $this->renderArray[$name];
    }
  }

  /**
   * Return a list of valid element types.
   *
   * @return array
   *   An array of valid types.
   */
  protected function validElementTypes() {
    return array();
  }
}
