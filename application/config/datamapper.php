<?php

/**
 * Data Mapper Configuration
 *
 * Global configuration settings that apply to all DataMapped models.
 */

$datamapper['prefix'] = '';
$datamapper['join_prefix'] = '';
$datamapper['error_prefix'] = '<p>';
$datamapper['error_suffix'] = '</p>';
$datamapper['created_field'] = 'created';
$datamapper['updated_field'] = 'updated';
$datamapper['local_time'] = FALSE;
$datamapper['unix_timestamp'] = FALSE;
$datamapper['timestamp_format'] = '';
$datamapper['lang_file_format'] = 'model_${model}';
$datamapper['field_label_lang_format'] = '${model}_${field}';
$datamapper['auto_transaction'] = FALSE;
$datamapper['auto_populate_has_many'] = FALSE;
$datamapper['auto_populate_has_one'] = FALSE;
$datamapper['all_array_uses_ids'] = FALSE;

// set to FALSE to use the same DB instance across the board (breaks subqueries)
// Set to any acceptable parameters to $CI->database() to override the default.
$datamapper['db_params'] = '';

// Uncomment to enable the production cache
// $datamapper['production_cache'] = APPPATH.'cache';

$datamapper['extensions_path'] = '../sparks/Datamapper-ORM/1.8.1-2/extensions';
$datamapper['extensions'] = array();

/* End of file datamapper.php */
/* Location: ./sparks/Datamapper-ORM/config/datamapper.php */
