<?php

namespace Drupal\ex_form\Form;

use Drupal\Core\Form\FormBase;                   // Базовый класс Form API
use Drupal\Core\Form\FormStateInterface;              // Класс отвечает за обработку данных

/**
 * Наследуемся от базового класса Form API
 *
 * @see \Drupal\Core\Form\FormBase
 */
class ExForm extends FormBase {


  // метод, который отвечает за саму форму - кнопки, поля
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = [];

    $form['config_form'] = [
      '#type' => 'fieldset',
      '#title' => t('E-Mail Form'),
    ];


    $form['config_form']['first_name'] = [
      '#type' => 'textfield',
      '#first_name' => $this->t('First Name'),
      '#description' => $this->t('Input your First Name'),
      '#required' => TRUE,
    ];

    $form['config_form']['last_name'] = [
      '#type' => 'textfield',
      '#last_name' => $this->t('Last Name'),
      '#description' => $this->t('Input your Last Name'),
      '#required' => TRUE,
    ];

    $form['config_form']['subject'] = [
      '#type' => 'textfield',
      '#subject' => $this->t('Subject'),
      '#description' => $this->t('Input Subject'),
      '#required' => TRUE,
    ];

    $form['config_form']['message'] = [
      '#type' => 'textarea',
      '#message' => $this->t('Message'),
      '#description' => $this->t('Input Message'),
      '#required' => TRUE,
    ];

    $form['config_form']['email'] = [
      '#type' => 'email',
      '#email' => $this->t('Email'),
      '#description' => $this->t('Input E-mail'),
      '#required' => TRUE,
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send Form'),
    ];

    return $form;
  }// END FORM INPUTS METHOD //

  // this method return form's name
  public function getFormId() {
    return 'ex_form_exform_form';
  }

  // Validator
  public function validateForm(array &$form, FormStateInterface $form_state) {

    function valid_email($str) {
      return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }

    $email = $form_state->getValue('email');

    if(!valid_email($email)){
      $form_state->setErrorByName('email', $this->t('Your email is incorrect. For example he must look so namemail@mail.com'));
    }
  }

  // Submit action
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $first_name = $form_state->getValue('first_name');
    $last_name = $form_state->getValue('last_name');
    $email = $form_state->getValue('email');

    // Logs a notice
    \Drupal::logger('my_module')->notice('Error submitting forms');
    // Logs an error
    \Drupal::logger('my_module')->error('Error submitting forms');


    drupal_set_message(t(
      "The your message was successful senden - %email sended success!!! User:  %first_name \n
      %last_name",
      [
        '%first_name' => $first_name,
        '%last_name'=> $last_name,
        '%email' => $email,
      ]));

  }

}
