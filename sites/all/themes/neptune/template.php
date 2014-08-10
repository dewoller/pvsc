<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */

/**
 * Override or insert variables into the page templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function neptune_preprocess_page(&$variables, $hook) {
  // Retrieve the theme setting value for 'neptune_max_width' and construct the
  // max-width HTML.
  $max_width = theme_get_setting('neptune_max_width') . 'px';
  $variables['max_width'] = 'style="max-width:' . $max_width . '"';
}

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function neptune_preprocess_node(&$variables, $hook) {
  // Modify Zen's default pubdate output.
  $variables['pubdate'] = '<time pubdate datetime="' . format_date($variables['node']->created, 'custom', 'c') . '">' . format_date($variables['node']->created, 'custom', 'jS F, Y') . ' &middot; ' . format_date($variables['node']->created, 'custom', 'g:ia') . '</time>';

  // Remove 'Submitted by ' and insert a middot.
  if ($variables['display_submitted']) {
    $variables['submitted'] = t('!username &middot; !datetime', array('!username' => $variables['name'], '!datetime' => $variables['pubdate']));
  }
}

/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
function neptune_preprocess_comment(&$variables, $hook) {
  // Modify Zen's default pubdate output.
  $variables['pubdate'] = '<time pubdate datetime="' . format_date($variables['comment']->created, 'custom', 'c') . '">' . format_date($variables['comment']->created, 'custom', 'jS F, Y') . ' &middot; ' . format_date($variables['comment']->created, 'custom', 'g:ia') . '</time>';

  // Replace 'replied on' with a middot.
  $variables['submitted'] = t('!username &middot; !datetime', array('!username' => $variables['author'], '!datetime' => $variables['pubdate']));
}

/**
 * Override status messages.
 *
 * Note: this overrides Zen's version of theme_status_messages().
 * @see zen_status_messages() (zen/template.php)
 *
 * Insert a '.messages-inner' div.
 */
function neptune_status_messages($variables) {
  $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
  );
  foreach (drupal_get_messages($display) as $type => $messages) {
    $output .= "<div class=\"messages--$type messages $type\"><div class=\"messages-inner\">\n";
    if (!empty($status_heading[$type])) {
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }
    if (count($messages) > 1) {
      $output .= " <ul class=\"messages__list\">\n";
      foreach ($messages as $message) {
        $output .= '  <li class=\"messages__item\">' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= $messages[0];
    }
    $output .= "</div></div>\n";
  }
  return $output;
}
