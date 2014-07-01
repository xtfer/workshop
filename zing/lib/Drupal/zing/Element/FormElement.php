<?php
/**
 * @file
 * Contains a FormElement Element
 *
 * @copyright Copyright(c) 2014 Christopher Skene
 * @license GPL v2 http://www.fsf.org/licensing/licenses/gpl.html
 * @author Chris Skene chris at xtfer dot com
 */

namespace Drupal\zing\Element;

/**
 * Defines a form element.
 */
class FormElement
  extends Element {

  /**
   * Set defaults for the element.
   */
  protected function defaults() {
    // Use element defaults.
    if (isset($this->type) && ($info = element_info($this->type))) {
      // Assign basic defaults common for all form elements.
      $this->setProperty('#required', FALSE);
      $this->setProperty('#attributes', array());
      $this->setProperty('#title_display', 'before');
      // Overlay $info onto $element, retaining preexisting keys in $element.
      foreach ($info as $key => $value) {
        $this->setProperty($key, $value);
      }
    }
  }

  /**
   * Apply an element state.
   *
   * @param mixed $state
   *   The state.
   */
  public function applyFormState($state) {
    $this->setProperty('#default value', $state);
  }

  /**
   * Set the title.
   *
   * @param string $title
   *   A title.
   *
   * @return \Drupal\zing\Element\FormElement
   *   The element for chaining.
   */
  public function setTitle($title) {
    $this->setProperty('#title', $title);

    return $this;
  }

  /**
   * Get the title.
   */
  public function getTitle() {
    return $this->getProperty('#title');
  }

  /**
   * Set the description.
   *
   * @param string $description
   *   A description
   *
   * @return \Drupal\zing\Element\FormElement
   *   An element for chaining.
   */
  public function setDescription($description) {
    $this->setProperty('#description', $description);

    return $this;
  }

  /**
   * Get the description.
   */
  public function getDescription() {
    return $this->getProperty('#description');
  }

  /**
   * Add an option.
   *
   * Used for any element requiring an #options array.
   *
   * @param string|int $key
   *   Key to use for the option.
   * @param string $value
   *   (optional) A value. If none is provided, the key is used.
   *
   * @return \Drupal\zing\Element\FormElement
   *   An element for chaining.
   */
  public function addOption($key, $value = NULL) {
    if (empty($value)) {
      $value = $key;
    }
    $options = $this->getProperty('#options', array());
    $options[$key] = $value;
    $this->setProperty('#options', $options);

    return $this;
  }
}
