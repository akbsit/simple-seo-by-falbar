<?php

	if(!defined('WP_UNINSTALL_PLUGIN')){

		exit;
	}

	delete_option('_falbar_ssbf_options_name');

	delete_metadata(
		'post',
		false,
		'_falbar_ssbf_title',
		'',
		true
	);
	delete_metadata(
		'post',
		false,
		'_falbar_ssbf_description',
		'',
		true
	);
	delete_metadata(
		'post',
		false,
		'_falbar_ssbf_keywords',
		'',
		true
	);

	delete_metadata(
		'term',
		false,
		'_falbar_ssbf_title',
		'',
		true
	);
	delete_metadata(
		'term',
		false,
		'_falbar_ssbf_description',
		'',
		true
	);
	delete_metadata(
		'term',
		false,
		'_falbar_ssbf_keywords',
		'',
		true
	);