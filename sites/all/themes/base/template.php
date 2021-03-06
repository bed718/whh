<?

/** 
 * @file
 * template.php for Gallery Base theme.
 * 
 * Implements preprocess and hook alter functions in this file.
 */
 
 
/**
 * Preprocess functions for page.tpl.php.
 */
function base_preprocess_page(&$vars){

}
 

/**
 * Preprocess functions for node.tpl.php.
 */
 
function base_preprocess_node(&$vars){
	$node = $vars['node'];
	$url = substr($vars['node_url'], 1);
	
	// Add general theme suggestions for all content types and view modes
	$vars['theme_hook_suggestions'][] = 'node__' . $vars['type'] . '__' . $vars['view_mode'];

	// PROJECT ====================================================
	if($vars['type'] == 'project'){
		
		$vars['body'] =  render($vars['content']['body']);
		$vars['images'] =  render($vars['content']['field_project_images']);
		$vars['location_date'] =  render($vars['content']['field_project_location_date']);
		$vars['photo_cred'] =  render($vars['content']['field_photo_credit']);
		$vars['contribs'] =  render($vars['content']['field_other_contributors']);
		$vars['cover_image'] = render_image($vars['field_project_images'][0]['uri'], 'project_full', '');
		$vars['teaser_image'] = render_image($vars['field_project_images'][0]['uri'], 'project_teaser', '');
		$vars['url'] = '/' . $url;

		if($vars['view_mode'] == 'featured'){
			drupal_add_js(path_to_theme() . '/js/init_featured.js');
		}

		if($vars['view_mode'] == 'full'){
			drupal_add_js(path_to_theme() . '/js/init_gallery.js');
		}
	}


	// PRESS ====================================================
	if($vars['type'] == 'press'){
		
		$vars['body'] =  render($vars['content']['body']);
		$vars['images'] =  render($vars['content']['field_press_image']);
		$vars['source'] =  render($vars['content']['field_original_source']);
		
		$vars['pdf'] =  render($vars['content']['field_press_pdf']);
		
		$vars['photo_cred'] =  render($vars['content']['field_photo_credit']);
		$vars['cover_image'] = render_image($vars['field_press_image'][0]['uri'], 'project_full', '');
		$vars['teaser_image'] = render_image($vars['field_press_image'][0]['uri'], 'project_teaser', '');
		$vars['url'] = '/' . $url;

		if($vars['view_mode'] == 'featured'){
			drupal_add_js(path_to_theme() . '/js/init_featured.js');
		}

		if($vars['view_mode'] == 'full'){
			drupal_add_js(path_to_theme() . '/js/init_gallery.js');
		}

	}

	// INTRO GALLERY ====================================================
	if($vars['type'] == 'intro_gallery'){
		$vars['images'] =  render($vars['content']['field_project_images']);
	}

}


// FORM ALTER
function base_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
    //$form['search_block_form']['#title'] = t('Search'); // Change the text on the label element
    //$form['search_block_form']['#title_display'] = 'invisible'; // Toggle label visibilty
    //$form['search_block_form']['#size'] = 40;  // define size of the textfield
    $form['search_block_form']['#default_value'] = t('Search'); // Set a default value for the textfield
    //$form['actions']['submit']['#value'] = t('GO!'); // Change the text on the submit button
    $form['actions']['submit'] = array('#type' => 'image_button', '#src' => base_path() . path_to_theme() . '/images/search_btn.png');

    // Add extra attributes to the text box
    $form['search_block_form']['#attributes']['onblur'] = "if (this.value == '') {this.value = 'Search';}";
    $form['search_block_form']['#attributes']['onfocus'] = "if (this.value == 'Search') {this.value = '';}";
    // Prevent user from searching the default text
    //$form['#attributes']['onsubmit'] = "if(this.search_block_form.value=='Search'){ alert('Please enter a search'); return false; }";

    // Alternative (HTML5) placeholder attribute instead of using the javascript
    $form['search_block_form']['#attributes']['placeholder'] = t('Search');
  }
} 

// Renders image with a given image style
function render_image($path, $style = 'default', $alt){
	$image_style = array( 'style_name' => $style, 'path' => $path, 'alt' => $alt);
	return theme('image_style', $image_style);
};


