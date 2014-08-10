<?php
/**
 * Implements hook_form_system_theme_settings_alter().
 *
 * @param $form
 *   Nested array of form elements that comprise the form.
 * @param $form_state
 *   A keyed array containing the current state of the form.
 */
function neptune_form_system_theme_settings_alter(&$form, &$form_state, $form_id = NULL)  {
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }

  // Add custom theme settings for Neptune.
  $form['custom'] = array(
    '#type'   => 'fieldset',
    '#title'  => t('Custom settings'),
    '#weight' => -15,
  );
  $form['custom']['neptune_max_width'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Max width'),
    '#description'   => t('The maximum width of the site in pixels (px).'),
    '#default_value' => theme_get_setting('neptune_max_width'),
    '#size'          => 5,
    '#maxlength'     => 10,
  );

  // We are directly editing $form, so don't need to return anything.
}
