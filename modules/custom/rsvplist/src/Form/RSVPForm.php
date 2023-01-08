<?php

/**
 * @file
 * A form to collect an email address for RSVP details.
 *
 */

namespace Drupal\rsvplist\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
//bring in drupal_set_message() function
use Drupal\Core\Action\Plugin\Action\MessageAction;
use Drupal\Core\Messenger\MessengerInterface;
//bring in t function
use Drupal\Core\StringTranslation;



class RSVPForm extends FormBase {
    
    /** 
     * {@inheritdoc}
    */
    public function getFormId() {
      return 'rsvplist_email_form';
    }

    /** 
     * {@inheritdoc}
    */
    public function buildForm(array $form, FormStateInterface $form_state) {
      $node = \Drupal::routeMatch()->getParameter('node');
      $nid = $node->nid->value;
      $form['email'] = array(
        '#title' => 'Email Address',
        '#type' => 'textfield',
        '#size' => 25,
        '#description' => "We'll send updates to the email address you provide.",
        '#required' => TRUE,
      );
      $form['submit'] = array(
        '#type' => 'submit',
        '#value' => 'RSVP',
      );
      $form['nid'] = array(
        '#type' => 'hidden',
        '#value' => $nid,
      );
      return $form;
    }

    /** 
     * {@inheritdoc}
    */
    public function validateForm(array &$form, FormStateInterface $form_state) {
      $value = $form_state->getValue('email');
      if ($value == !\Drupal::service('email.validator')->isValid($value)) {
        $form_state->setErrorByName('email', 'The email address %mail is not valid.', array('%mail' => $value));
      }
    }

    /** 
     * {@inheritdoc}
    */
    public function submitForm(array &$form, FormStateInterface $form_state) {
      $nid = $form_state->getValue('nid');
      $submitted_email = $form_state->getValue('email');
      $this->messenger()->addMessage('The form is working, you entered: ' . $submitted_email);

    //   $message = \Drupal::service('plugin.manager.mail')->mail('rsvplist', 'rsvpemail', $form_state->getValue('email'),
    //     \Drupal::languageManager()->getDefaultLanguage(), 
    //     array('message' => '@entry, you have successfully RSVPed for the event.', ['@entry' => $submitted_email]), NULL, TRUE);
    //   if ($message['result'] !== TRUE) {
    //     drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
    //   }
    //   else {
    //     drupal_set_message(t('Your RSVP has been sent.'));
    //   }
    }
}