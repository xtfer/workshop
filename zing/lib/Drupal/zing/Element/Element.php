<?php

/**
 * @file
 * Contains an Element
 *
 * @copyright Copyright(c) 2014 Christopher Skene
 * @license GPL v2 http://www.fsf.org/licensing/licenses/gpl.html
 * @author Chris Skene chris at xtfer dot com
 */

namespace Drupal\zing\Element;

/**
 * A standard Element.
 */
class Element {

  /**
   * Reference to the handler.
   *
   * @var \Drupal\zing\Handler\HandlerInterface
   */
  protected $handler;

  /**
   * The element type.
   *
   * @var string
   */
  protected $type;

  /**
   * The element machine name.
   *
   * @var string
   */
  protected $name;

  /**
   * Element properties.
   *
   * @var array
   */
  protected $properties = array();

  /**
   * Constructor.
   *
   * @param string $name
   *   Name of the element.
   * @param \Drupal\zing\Handler\HandlerInterface|null $handler
   *   (optional) A handler reference.
   */
  public function __construct($name, $handler = NULL) {
    $this->setName($name);
    if (!empty($handler)) {
      $this->handler = $handler;
    }
  }

  /**
   * Set defaults for the element.
   */
  protected function defaults() {
    // @todo
  }

  /**
   * Load an element from a form array element.
   *
   * @param array $element
   *   A form element.
   */
  public function loadElement($element) {
    foreach ($element as $key => $value) {
      $this->setProperty($key, $value);
    }
  }

  /**
   * Return the render array for this element.
   */
  public function renderArray() {
    $element = array();
    $element['#type'] = $this->getType();
    foreach ($this->properties as $key => $value) {
      $element[$key] = $value;
    }

    return $element;
  }

  /**
   * Set the element type.
   *
   * @param string $type
   *   Name of the type.
   */
  public function setType($type) {

    $this->type = $type;
    $this->defaults();
  }

  /**
   * Get the element type.
   *
   * @return string
   *   Name of the type.
   */
  public function getType() {

    return $this->type;
  }

  /**
   * Set the name.
   *
   * @todo: validation
   *
   * @param string $name
   *   A valid machine name.
   */
  public function setName($name) {

    $this->name = $name;
  }

  /**
   * Get the name.
   *
   * @return string
   *   The machine name.
   */
  public function getName() {

    return $this->name;
  }

  /**
   * Set the #value.
   *
   * @param string $value
   *   A value.
   */
  public function setValue($value) {

    $this->setProperty('#value', $value);
  }

  /**
   * Get the #value.
   *
   * @return string
   *   The value.
   */
  public function getValue() {

    return $this->getProperty('#value', NULL);
  }

  /**
   * Set a property directly.
   *
   * @todo: validation
   *
   * @param string $key
   *   Property name.
   * @param mixed $value
   *   Value to set the property to.
   */
  public function setProperty($key, $value) {

    $this->properties[$key] = $value;
  }

  /**
   * Return a property value.
   *
   * @param string $key
   *   Property name.
   * @param string|null $default_value
   *   (optional) A default value.
   *
   * @return mixed
   *   Value of the property.
   */
  public function getProperty($key, $default_value = ZING_NO_VALUE) {
    if (isset($this->properties[$key])) {
      return $this->properties[$key];
    }

    if (isset($default_value) && $default_value != ZING_NO_VALUE) {
      return $default_value;
    }
  }

  /**
   * Implements __destruct().
   */
  public function __destruct() {
    unset($this->handler);
  }

  /**
   * Implements __sleep().
   */
  public function __sleep() {
    if (isset($this->handler)) {
      $handler_class = get_class($this->handler);
      $this->handler = $handler_class;
    }
  }

  /**
   * Implements __wakeup().
   */
  public function __wakeup() {
    if (isset($this->handler)) {
      if (class_exists($this->handler)) {
        try {
          $class = new $this->handler();
          $this->handler = $class;
        }
        catch(\Exception $e) {
          watchdog_exception('zing', $e, 'Could not start handler class');
        }
      }
    }
  }

}
