<?php 

class Settings_Model extends App_Model {

    protected $join = array(
        'settings_categories' => 'settings_categories.id = settings.id_module'
    );

    protected $base_select = 'settings.id, settings.setting, settings.title, settings.type, settings.default, settings.value, settings.options, settings.is_required,  settings.order';
    protected $where       = 'settings.active = 1';
    protected $table       = 'settings';

}