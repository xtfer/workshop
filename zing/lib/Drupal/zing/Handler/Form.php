<?php
/**
 * @file
 * Contains a Form Handler.
 *
 * @copyright Copyright(c) 2014 Christopher Skene
 * @license GPL v2 http://www.fsf.org/licensing/licenses/gpl.html
 * @author Chris Skene chris at xtfer dot com
 */

namespace Drupal\zing\Handler;

use Drupal\zing\Element\FormElement;

/**
 * A form handler.
 */
class Form
  extends BaseHandler {

  /**
   * Create a new element.
   *
   * @param string $name
   *   Name of the element.
   *
   * @return \Drupal\zing\Element\Element
   *   The element.
   */
  protected function newElement($name) {
    return new FormElement($name, $this);
  }

  /**
   * Return a list of valid element types.
   *
   * @return array
   *   An array of valid types.
   */
  protected function validElementTypes() {
    return array('checkbox', 'checkboxes', 'date', 'fieldset', 'file',
      'machine_name', 'managed_file', 'password', 'password_confirm', 'radio',
      'radios', 'select', 'tableselect', 'text_format', 'textarea', 'textfield',
      'vertical_tabs', 'weight', 'actions', 'button', 'container',
      'image_button', 'submit', 'form', 'hidden', 'token', 'markup', 'item',
      'value');
  }

  /**
   * Load a form array into this object.
   *
   * @param array $form
   *   A form array.
   */
  public function loadForm($form) {
    if (!empty($form)) {
      $children = element_children($form);

      $this->removeFormKey($children, 'form_build_id');
      $this->removeFormKey($children, 'form_token');
      $this->removeFormKey($children, 'form_id');

      foreach ($children as $key) {

        $this->addElement($form[$key]['#type'], $key)
          ->loadElement($form[$key]);
      }
    }
  }

  /**
   * Update form values with the current form state.
   *
   * @param array $form_state
   *   The form state.
   */
  public function applyFormState($form_state) {
    if (!empty($form_state)) {
      foreach (array_keys($this->renderArray) as $key) {
        $this->getElement($key)->applyFormState($form_state[$key]);
      }
    }
  }

  /**
   * Given a form and key, unset it.
   *
   * @param array $form
   *   The form.
   * @param string $key
   *   The key.
   */
  protected function removeFormKey(&$form, $key) {
    if (array_key_exists($key, $form)) {
      unset($form[$key]);
    }
  }

  /**
   * Return the form.
   *
   * @return array
   *   A form array.
   */
  public function getForm() {
    $form = array();
    foreach (array_keys($this->renderArray) as $form_key) {
      $form[$form_key] = $this->getElement($form_key)->renderArray();
    }
    return $form;
  }

  /**
   * Shortcut to add a submit button.
   */
  public function addSubmit() {
    $this->addElement('submit', 'submit')
      ->setValue('Submit');
  }
}
