<?php
namespace Drupal\extended_site_information\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

// This is the core form we are extending.
use Drupal\system\Form\SiteInformationForm;

/**
 * Configure site information settings for this site.
 */
class ExtendedSiteInformationForm extends SiteInformationForm
{
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
      // Retrieve the system.site configuration.
      $site_config = $this->config('system.site');

      // Get the original form from the class we are extending.
      $form = parent::buildForm($form, $form_state);

      // Add a text field to the site information section of the form for site
      // API key.
      $form['site_information']['site_api_key'] = [
        '#type' => 'textfield',
        '#title' => t('Site API Key'),
        '#default_value' => ($site_config->get('siteapikey')) ? $site_config->get('siteapikey') : 'No API Key yet',
        '#description' => $this->t('The API key of the site'),
      ];
      // Change the text of submit button.
      $form['actions']['submit']['#value'] = t('Update Configuration');

      return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    if ($form_state->getValue('site_api_key') != 'No API Key yet') {
      // Save the value of siteapikey to system.site.siteapikey configuration.
      $this->config('system.site')->set('siteapikey', $form_state->getValue('site_api_key'))->save();

      // Pass the remaining field values to the original form to save them
      // as well.
      parent::submitForm($form, $form_state);
    }
  }
}
