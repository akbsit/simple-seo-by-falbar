<?php

	defined('SSBF') or die();

	class Falbar_SSBF_Core{

		protected $main_file_path;
		protected $main_file_name 	 = 'simple-seo-by-falbar.php';
		protected $plugin_name 		 = 'Simple SEO by falbar';
		protected $plugin_short_name = 'Simple SEO';
		protected $prefix_db 		 = '_falbar_ssbf';
		protected $prefix 			 = 'ssbf';
		protected $plugin_id 		 = 'falbarSeoBox';
		protected $plugin_version 	 = '1.1';
		protected $plugin_domain 	 = 'simple-seo-by-falbar';

		protected function get_post_seo_data($id){

			return array(
				'title' 	  => get_post_meta($id, $this->prefix_db.'_title', true),
				'description' => get_post_meta($id, $this->prefix_db.'_description', true),
				'keywords' 	  => get_post_meta($id, $this->prefix_db.'_keywords', true)
			);
		}

		protected function get_term_seo_data($id){

			return array(
				'title' 	  => get_term_meta($id, $this->prefix_db.'_title', true),
				'description' => get_term_meta($id, $this->prefix_db.'_description', true),
				'keywords' 	  => get_term_meta($id, $this->prefix_db.'_keywords', true)
			);
		}

		protected function get_meta_template($params){

			$tmp  = "\n\r";
			$tmp .= '<!-- '.$this->plugin_name.' v '.$this->plugin_version.' -->';
			$tmp .= "\n";

				$tmp .= '<meta name="description" content="'.$params['description'].'" />';
				$tmp .= "\n";
				$tmp .= '<meta name="keywords" content="'.$params['keywords'].'" />';
				$tmp .= "\n";
				$tmp .= '<title>'.$params['title'].'</title>';

			$tmp .= "\n";
			$tmp .= '<!--/ '.$this->plugin_name.' -->';
			$tmp .= "\n\r";

			return $tmp;
		}
	}