<?php

	defined('SSBF') or die();

	class Falbar_SSBF extends Falbar_SSBF_Core{

		public function __construct(){

			$this->main_file_path = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$this->main_file_name;

			return false;
		}

		public function run(){

			// Activation of the plugin
			register_activation_hook(
				$this->main_file_path,
				array(
					$this,
					'activate'
				)
			);

			// Deactivating the plugin
			register_deactivation_hook(
				$this->main_file_path,
				array(
					$this,
					'deactivate'
				)
			);

			// Adding the settings page
			add_action(
				'admin_menu',
				array(
					$this,
					'admin_menu'
				)
			);

				// Adding sections and fields
				add_action(
					'admin_init',
					array(
						$this,
						'admin_menu_settings'
					)
				);

				// Add alert
				add_action(
					'admin_notices',
					array(
						$this,
						'admin_notices'
					)
				);

			// Adding a box on the page posts (post, page)
			add_action(
				'add_meta_boxes',
				array(
					$this,
					'add_meta_boxes'
				)
			);

				// Save the SEO data
				add_action(
					'save_post',
					array(
						$this,
						'save_post'
					)
				);

			// Add fields for conditions (category, tag)
			add_action(
				'edit_category_form_fields',
				array(
					$this,
					'term_view'
				)
			);
			add_action(
				'edit_tag_form_fields',
				array(
					$this,
					'term_view'
				)
			);

				// Save the SEO data
				add_action(
					'edited_category',
					array(
						$this,
						'save_term'
					)
				);
				add_action(
					'edited_post_tag',
					array(
						$this,
						'save_term'
					)
				);

			// Add SEO tags to the template
			add_action(
				'wp_head',
				array(
					$this,
					'add_meta_tags'
				),
				0
			);

			// Localization plugin
			add_action(
				'plugins_loaded',
				array(
					$this,
					'plugin_textdomain'
				)
			);

			return false;
		}

		public function activate(){

			return false;
		}

		public function deactivate(){

			return false;
		}

		public function admin_menu(){

			add_menu_page(
				$this->plugin_name,
				$this->plugin_short_name,
				'manage_options',
				$this->main_file_name,
				array(
					$this,
					'admin_menu_view'
				),
				'dashicons-awards',
				81,00012345677
			);

			return false;
		}

			public function admin_menu_view(){

				echo('<div class="wrap">');
					echo('<h1>'.__('Settings', $this->plugin_domain).' '.$this->plugin_name.'</h1>');
					echo('<form action="options.php" method="post">');

						settings_fields($this->prefix_db.'_options_group');
						do_settings_sections($this->main_file_name);
						submit_button();

					echo('</form>');
				echo('</div>');

				return false;
			}

		public function admin_menu_settings(){

			register_setting(
				$this->prefix_db.'_options_group',
				$this->prefix_db.'_options_name',
				array(
					$this,
					'sanitize_options'
				)
			);

			add_settings_section(
				$this->prefix.'_section_home_page_id',
				__('Home page', $this->plugin_domain),
				'',
				$this->main_file_name
			);

				add_settings_field(
					$this->prefix.'_setting_home_page_id',
					'Title',
					array(
						$this,
						'field_setting_home_page_view'
					),
					$this->main_file_name,
					$this->prefix.'_section_home_page_id',
					array(
						'label_for' => $this->prefix.'_setting_home_page_title'
					)
				);

				add_settings_field(
					$this->prefix.'_setting_home_page_id2',
					'Description',
					array(
						$this,
						'field_setting_home_page_view2'
					),
					$this->main_file_name,
					$this->prefix.'_section_home_page_id',
					array(
						'label_for' => $this->prefix.'_setting_home_page_description'
					)
				);

				add_settings_field(
					$this->prefix.'_setting_home_page_id3',
					'Keywords',
					array(
						$this,
						'field_setting_home_page_view3'
					),
					$this->main_file_name,
					$this->prefix.'_section_home_page_id',
					array(
						'label_for' => $this->prefix.'_setting_home_page_keywords'
					)
				);

			add_settings_section(
				$this->prefix.'_section_404_page_id',
				__('404 page', $this->plugin_domain),
				'',
				$this->main_file_name
			);

				add_settings_field(
					$this->prefix.'_setting_404_page_id',
					'Title',
					array(
						$this,
						'field_setting_404_page_view'
					),
					$this->main_file_name,
					$this->prefix.'_section_404_page_id',
					array(
						'label_for' => $this->prefix.'_setting_404_page_title'
					)
				);

				add_settings_field(
					$this->prefix.'_setting_404_page_id2',
					'Description',
					array(
						$this,
						'field_setting_404_page_view2'
					),
					$this->main_file_name,
					$this->prefix.'_section_404_page_id',
					array(
						'label_for' => $this->prefix.'_setting_404_page_description'
					)
				);

				add_settings_field(
					$this->prefix.'_setting_404_page_id3',
					'Keywords',
					array(
						$this,
						'field_setting_404_page_view3'
					),
					$this->main_file_name,
					$this->prefix.'_section_404_page_id',
					array(
						'label_for' => $this->prefix.'_setting_404_page_keywords'
					)
				);

			return false;
		}

			public function sanitize_options($options){

				$clean_options = array();

				foreach($options as $k => $v){

					$clean_options[$k] = strip_tags($v);
				}

				return $clean_options;
			}

			public function field_setting_home_page_view(){

				$options = get_option($this->prefix_db.'_options_name');

				if(!$options['home_title']){

					$options['home_title'] = get_bloginfo('name');

					if(get_bloginfo('description')){

						$options['home_title'] .= ' - '.get_bloginfo('description');
					}
				}

				echo('<input id="'.$this->prefix.'_setting_home_page_title" type="text" name="'.$this->prefix_db.'_options_name[home_title]" value="'.esc_attr($options['home_title']).'" class="regular-text" />');

				return false;
			}

			public function field_setting_home_page_view2(){

				$options = get_option($this->prefix_db.'_options_name');

				echo('<textarea id="'.$this->prefix.'_setting_home_page_description" name="'.$this->prefix_db.'_options_name[home_description]" cols="50" rows="5"  class="large-text">'.esc_attr($options['home_description']).'</textarea>');

				return false;
			}

			public function field_setting_home_page_view3(){

				$options = get_option($this->prefix_db.'_options_name');

				echo('<textarea id="'.$this->prefix.'_setting_home_page_keywords" name="'.$this->prefix_db.'_options_name[home_keywords]" cols="50" rows="2" class="large-text">'.esc_attr($options['home_keywords']).'</textarea>');

				return false;
			}

			public function field_setting_404_page_view(){

				$options = get_option($this->prefix_db.'_options_name');

				if(!$options['404_title']){

					$options['404_title'] = __('Page not found', $this->plugin_domain);

					if(get_bloginfo('description')){

						$options['404_title'] .= ' - '.get_bloginfo('description');
					}
				}

				echo('<input id="'.$this->prefix.'_setting_404_page_title" type="text" name="'.$this->prefix_db.'_options_name[404_title]" value="'.esc_attr($options['404_title']).'" class="regular-text" />');

				return false;
			}

			public function field_setting_404_page_view2(){

				$options = get_option($this->prefix_db.'_options_name');

				echo('<textarea id="'.$this->prefix.'_setting_404_page_description" name="'.$this->prefix_db.'_options_name[404_description]" cols="50" rows="5"  class="large-text">'.esc_attr($options['404_description']).'</textarea>');

				return false;
			}

			public function field_setting_404_page_view3(){

				$options = get_option($this->prefix_db.'_options_name');

				echo('<textarea id="'.$this->prefix.'_setting_404_page_keywords" name="'.$this->prefix_db.'_options_name[404_keywords]" cols="50" rows="2" class="large-text">'.esc_attr($options['404_keywords']).'</textarea>');

				return  false;
			}

		public function admin_notices(){

			if(!empty($_GET['page']) && $_GET['page'] == $this->main_file_name){

				if(!empty($_GET['settings-updated']) && $_GET['settings-updated'] == true){

					echo('<div class="updated notice is-dismissible">');

						echo('<p>');
							echo('<strong>'.__('Settings saved.', $this->plugin_domain).'</strong>');
						echo('</p>');

						echo('<button class="notice-dismiss" type="button">');
							echo('<span class="screen-reader-text">');
								echo(__('Dismiss this notice.', $this->plugin_domain));
							echo('</span>');
						echo('</button>');

					echo('</div>');
				}
			}

			return false;
		}

		public function add_meta_boxes(){

			add_meta_box(
				$this->plugin_id,
				$this->plugin_name,
				array(
					$this,
					'boxes_view'
				),
				'post'
			);

			add_meta_box(
				$this->plugin_id,
				$this->plugin_name,
				array(
					$this,
					'boxes_view'
				),
				'page'
			);

			return false;
		}

			public function boxes_view($post){

				$data = $this->get_post_seo_data($post->ID);

				echo('<table class="form-table">');

					echo('<tr class="form-field">');
						echo('<th>');
							echo('<label for="'.$this->prefix.'-title">Title</label>');
						echo('</th>');
						echo('<td>');
							echo('<input id="'.$this->prefix.'-title" type="text" name="'.$this->prefix.'_title" value="'.esc_attr($data['title']).'" />');
						echo('</td>');
					echo('</tr>');

					echo('<tr class="form-field">');
						echo('<th>');
							echo('<label for="'.$this->prefix.'-description">Description</label>');
						echo('</th>');
						echo('<td>');
							echo('<textarea id="'.$this->prefix.'-description" class="large-text" cols="50" rows="5" name="'.$this->prefix.'_description">'.esc_attr($data['description']).'</textarea>');
						echo('</td>');
					echo('</tr>');

					echo('<tr class="form-field">');
						echo('<th>');
							echo('<label for="'.$this->prefix.'-keywords">Keywords</label>');
						echo('</th>');
						echo('<td>');
							echo('<textarea id="'.$this->prefix.'-keywords" class="large-text" cols="50" rows="2" name="'.$this->prefix.'_keywords">'.esc_attr($data['keywords']).'</textarea>');
						echo('</td>');
					echo('</tr>');

				echo('</table>');

				return false;
			}

		public function save_post($id){

			if(!empty($_POST[$this->prefix.'_title']) ||
			   !empty($_POST[$this->prefix.'_description']) ||
			   !empty($_POST[$this->prefix.'_keywords'])){

				$title 		 = sanitize_text_field($_POST[$this->prefix.'_title']);
				$description = sanitize_text_field($_POST[$this->prefix.'_description']);
				$keywords 	 = sanitize_text_field($_POST[$this->prefix.'_keywords']);

				update_post_meta($id, $this->prefix_db.'_title', $title);
				update_post_meta($id, $this->prefix_db.'_description', $description);
				update_post_meta($id, $this->prefix_db.'_keywords', $keywords);

				return true;
			}

			return false;
		}

		public function term_view($term){

			if($term->taxonomy == 'category' || $term->taxonomy == 'post_tag'){

				$data = $this->get_term_seo_data($term->term_id);

				echo('<tr class="form-field">');
					echo('<th>');
						echo('<label for="'.$this->prefix.'-title">Title</label>');
					echo('</th>');
					echo('<td>');
						echo('<input id="'.$this->prefix.'-title" type="text" name="'.$this->prefix.'_title" value="'.esc_attr($data['title']).'" />');
						echo('<p class="description">'.$this->plugin_name.'</p>');
					echo('</td>');
				echo('</tr>');

				echo('<tr class="form-field">');
					echo('<th>');
						echo('<label for="'.$this->prefix.'-description">Description</label>');
					echo('</th>');
					echo('<td>');
						echo('<textarea id="'.$this->prefix.'-description" class="large-text" cols="50" rows="5" name="'.$this->prefix.'_description">'.esc_attr($data['description']).'</textarea>');
						echo('<p class="description">'.$this->plugin_name.'</p>');
					echo('</td>');
				echo('</tr>');

				echo('<tr class="form-field">');
					echo('<th>');
						echo('<label for="'.$this->prefix.'-keywords">Keywords</label>');
					echo('</th>');
					echo('<td>');
						echo('<textarea id="'.$this->prefix.'-keywords" class="large-text" cols="50" rows="2" name="'.$this->prefix.'_keywords">'.esc_attr($data['keywords']).'</textarea>');
						echo('<p class="description">'.$this->plugin_name.'</p>');
					echo('</td>');
				echo('</tr>');
			}

			return false;
		}

		public function save_term($id){

			if(!empty($_POST[$this->prefix.'_title']) ||
			   !empty($_POST[$this->prefix.'_description']) ||
			   !empty($_POST[$this->prefix.'_keywords'])){

				$title 		 = sanitize_text_field($_POST[$this->prefix.'_title']);
				$description = sanitize_text_field($_POST[$this->prefix.'_description']);
				$keywords 	 = sanitize_text_field($_POST[$this->prefix.'_keywords']);

				update_term_meta($id, $this->prefix_db.'_title', $title);
				update_term_meta($id, $this->prefix_db.'_description', $description);
				update_term_meta($id, $this->prefix_db.'_keywords', $keywords);

				return true;
			}

			return false;
		}

		public function add_meta_tags(){

			$page_obj  = get_queried_object();

			$post_type = $page_obj->post_type;
			$taxonomy  = $page_obj->taxonomy;

			if(is_home() || is_front_page() ||
			   is_404() ||
			   (is_single() && $post_type == 'post') ||
			   (is_page() && $post_type == 'page') ||
			   (is_category() && $taxonomy == 'category') ||
			   (is_tag() && $taxonomy == 'post_tag')){

				remove_theme_support('title-tag');
				remove_action('wp_head', '_wp_render_title_tag', 1);
			}

			$html = '';

			// Home page
			if(is_home() || is_front_page()){

				$options = get_option($this->prefix_db.'_options_name');

				if(!$options['home_title']){

					$options['home_title'] = get_bloginfo('name');

					if(get_bloginfo('description')){

						$options['home_title'] .= ' - '.get_bloginfo('description');
					}
				}

				$html = $this->get_meta_template(array(
					'title' 	  => $options['home_title'],
					'description' => $options['home_description'],
					'keywords' 	  => $options['home_keywords']
				));
			}
			// 404
			elseif(is_404()){

				$options = get_option($this->prefix_db.'_options_name');

				if(!$options['404_title']){

					$options['404_title'] = __('Page not found', $this->plugin_domain);

					if(get_bloginfo('description')){

						$options['404_title'] .= ' - '.get_bloginfo('description');
					}
				}

				$html = $this->get_meta_template(array(
					'title' 	  => $options['404_title'],
					'description' => $options['404_description'],
					'keywords' 	  => $options['404_keywords']
				));
			}
			// post
			if(is_single() && $post_type == 'post'){

				global $post;

				$title 		 = get_post_meta($post->ID, $this->prefix_db.'_title', true);
				$description = get_post_meta($post->ID, $this->prefix_db.'_description', true);
				$keywords 	 = get_post_meta($post->ID, $this->prefix_db.'_keywords', true);

				if(!$title){

					$title = $post->post_title;
				}

				$html = $this->get_meta_template(array(
					'title' 	  => $title,
					'description' => $description,
					'keywords' 	  => $keywords
				));
			}
			// page
			elseif(is_page() && $post_type == 'page'){

				global $post;

				$title 		 = get_post_meta($post->ID, $this->prefix_db.'_title', true);
				$description = get_post_meta($post->ID, $this->prefix_db.'_description', true);
				$keywords 	 = get_post_meta($post->ID, $this->prefix_db.'_keywords', true);

				if(!$title){

					$title = $post->post_title;
				}

				$html = $this->get_meta_template(array(
					'title' 	  => $title,
					'description' => $description,
					'keywords' 	  => $keywords
				));
			}
			// category
			elseif(is_category() && $taxonomy == 'category'){

				$cat_id = get_query_var('cat');

				$data = $this->get_term_seo_data($cat_id);

				if(!$data['title']){

					$cat = get_category($cat_id);

					$data['title'] = $cat->name;
				}

				$html = $this->get_meta_template(array(
					'title' 	  => $data['title'],
					'description' => $data['description'],
					'keywords' 	  => $data['keywords']
				));
			}
			// tag
			elseif(is_tag() && $taxonomy == 'post_tag'){

				$tag_id = get_query_var('tag_id');

				$data = $this->get_term_seo_data($tag_id);

				if(!$data['title']){

					$tag = get_tag($tag_id);

					$data['title'] = $tag->name;
				}

				$html = $this->get_meta_template(array(
					'title' 	  => $data['title'],
					'description' => $data['description'],
					'keywords' 	  => $data['keywords']
				));
			}

			echo($html);

			return false;
		}

		public function plugin_textdomain(){

			load_plugin_textdomain(
				$this->plugin_domain,
				false,
				dirname(dirname(plugin_basename(__FILE__ ))).'/languages/'
			);

			return false;
		}

		public function get_falbar_ssbf_data($params){

			if(!empty($params['property'])){

				$property = '';

				switch($params['property']){

					case 'plugin_id':
						$property = $this->plugin_id;
						break;

					case 'plugin_name':
						$property = $this->plugin_name;
						break;

					case 'prefix':
						$property = $this->prefix;
						break;

					case 'version':
						$property = $this->plugin_version;
						break;
				}

				return $property;
			}

			if(!empty($params['method'])){

				$method = '';

				switch($params['method']['name']){

					case 'get_meta_template':
						$method = $this->get_meta_template(array(
							'title' 	  => $params['method']['values']['title'],
							'description' => $params['method']['values']['description'],
							'keywords' 	  => $params['method']['values']['keywords']
						));
						break;
				}

				return $method;
			}

			return false;
		}
	}