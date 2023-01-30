<?php 	
	
	defined('MOODLE_INTERNAL') || die();
	
    /* Megadropdown menu */	
	$page = new admin_settingpage('theme_maker_dropdown', get_string('dropdownheading', 'theme_maker'));
	
	
	$page->add(new admin_setting_heading('theme_maker_dropdownheadingsub', get_string('dropdownheadingsub', 'theme_maker'),
            format_text(get_string('dropdownheadingsubdesc' , 'theme_maker'), FORMAT_MARKDOWN)));
            
            
	//Enable Dropdown Menu
    $name = 'theme_maker/usedropdown';
    $title = get_string('usedropdown', 'theme_maker');
    $description = get_string('usedropdowndesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Dropdown Menu Name
    $name = 'theme_maker/dropdownname';
    $title = get_string('dropdownname', 'theme_maker');
    $description = get_string('dropdownnamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Dropdown Menu Content Heading
    $name = 'theme_maker/dropdowncontentheading';
    $title = get_string('dropdowncontentheading', 'theme_maker');
    $description = get_string('dropdowncontentheadingdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    

    // Dropdown Menu Column Number Switcher
    $name = 'theme_maker/dropdowncolnumber';
    $title = get_string('dropdowncolnumber', 'theme_maker');
    $description = get_string('dropdowncolnumberdesc', 'theme_maker');
    $default = 'column-1';
    $choices = array(
	        '1' => '1',
	        '2' => '2',
	        '3' => '3',
	        '4' => '4',
	    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$page->add($setting);

    
    // Dropdown Menu CTA Button Info
    $name = 'theme_maker/dropdownbuttoninfo';
    $heading = get_string('dropdownbuttoninfo', 'theme_maker');
    $information = get_string('dropdownbuttoninfodesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Dropdown Menu CTA Button Text
    $name = 'theme_maker/dropdownbuttontext';
    $title = get_string('dropdownbuttontext', 'theme_maker');
    $description = get_string('dropdownbuttontextdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // CTA Section CTA Button URL
    $name = 'theme_maker/dropdownbuttonurl';
    $title = get_string('dropdownbuttonurl', 'theme_maker');
    $description = get_string('dropdownbuttonurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // URL open in new window    
    $name = 'theme_maker/dropdownbuttonurlopennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    

	/* Dropdown Item 1 */	
    $name = 'theme_maker/dropdownitem1info';
    $heading = get_string('dropdownitem1info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem1title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    
    $name = 'theme_maker/dropdownitem1url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem1opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Dropdown Item 2 */	
    $name = 'theme_maker/dropdownitem2info';
    $heading = get_string('dropdownitem2info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem2title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem2url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem2opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Dropdown Item 3 */	
    $name = 'theme_maker/dropdownitem3info';
    $heading = get_string('dropdownitem3info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem3title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem3url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem3opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
     
    
    
    /* Dropdown Item 4 */	
    $name = 'theme_maker/dropdownitem4info';
    $heading = get_string('dropdownitem4info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem4title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    
    $name = 'theme_maker/dropdownitem4url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem4opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    
    /* Dropdown Item 5 */	
    $name = 'theme_maker/dropdownitem5info';
    $heading = get_string('dropdownitem5info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem5title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem5url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem5opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    
    /* Dropdown Item 6 */	
    $name = 'theme_maker/dropdownitem6info';
    $heading = get_string('dropdownitem6info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem6title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem6url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem6opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    
    /* Dropdown Item 7 */	
    $name = 'theme_maker/dropdownitem7info';
    $heading = get_string('dropdownitem7info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem7title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem7url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem7opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Dropdown Item 8 */	
    $name = 'theme_maker/dropdownitem8info';
    $heading = get_string('dropdownitem8info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem8title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_maker/dropdownitem8url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem8opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    
    /* Dropdown Item 9 */	
    $name = 'theme_maker/dropdownitem9info';
    $heading = get_string('dropdownitem9info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem9title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem9url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem9opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    
    /* Dropdown Item 10 */	
    $name = 'theme_maker/dropdownitem10info';
    $heading = get_string('dropdownitem10info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem10title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem10url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem10opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    
    /* Dropdown Item 11 */	
    $name = 'theme_maker/dropdownitem11info';
    $heading = get_string('dropdownitem11info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem11title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem11url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem11opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    
    /* Dropdown Item 12 */	
    $name = 'theme_maker/dropdownitem12info';
    $heading = get_string('dropdownitem12info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem12title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem12url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem12opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    
    /* Dropdown Item 13 */	
    $name = 'theme_maker/dropdownitem13info';
    $heading = get_string('dropdownitem13info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem13title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem13url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem13opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    
    /* Dropdown Item 14 */	
    $name = 'theme_maker/dropdownitem14info';
    $heading = get_string('dropdownitem14info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem14title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem14url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem14opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    
    /* Dropdown Item 15 */	
    $name = 'theme_maker/dropdownitem15info';
    $heading = get_string('dropdownitem15info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem15title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem15url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem15opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    

    
    /* Dropdown Item 16 */	
    $name = 'theme_maker/dropdownitem16info';
    $heading = get_string('dropdownitem16info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem16title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem16url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem16opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Dropdown Item 17 */	
    $name = 'theme_maker/dropdownitem17info';
    $heading = get_string('dropdownitem17info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem17title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem17url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem17opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    
    /* Dropdown Item 18 */	
    $name = 'theme_maker/dropdownitem18info';
    $heading = get_string('dropdownitem18info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem18title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem18url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem18opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Dropdown Item 19 */	
    $name = 'theme_maker/dropdownitem19info';
    $heading = get_string('dropdownitem19info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem19title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem19url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem19opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Dropdown Item 20 */	
    $name = 'theme_maker/dropdownitem20info';
    $heading = get_string('dropdownitem20info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem20title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem20url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem20opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Dropdown Item 21 */	
    $name = 'theme_maker/dropdownitem21info';
    $heading = get_string('dropdownitem21info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem21title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem21url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem21opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Dropdown Item 22 */	
    $name = 'theme_maker/dropdownitem22info';
    $heading = get_string('dropdownitem22info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem22title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem22url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem22opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Dropdown Item 23 */	
    $name = 'theme_maker/dropdownitem23info';
    $heading = get_string('dropdownitem23info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem23title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem23url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem23opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Dropdown Item 24 */	
    $name = 'theme_maker/dropdownitem24info';
    $heading = get_string('dropdownitem24info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem24title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem24url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem24opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Dropdown Item 25 */	
    $name = 'theme_maker/dropdownitem25info';
    $heading = get_string('dropdownitem25info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem25title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem25url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem25opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Dropdown Item 26 */	
    $name = 'theme_maker/dropdownitem26info';
    $heading = get_string('dropdownitem26info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem26title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem26url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem26opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Dropdown Item 27 */	
    $name = 'theme_maker/dropdownitem27info';
    $heading = get_string('dropdownitem27info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem27title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem27url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem27opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Dropdown Item 28 */	
    $name = 'theme_maker/dropdownitem28info';
    $heading = get_string('dropdownitem28info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem28title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem28url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem28opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    /* Dropdown Item 29 */	
    $name = 'theme_maker/dropdownitem29info';
    $heading = get_string('dropdownitem29info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem29title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem29url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem29opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    /* Dropdown Item 30 */	
    $name = 'theme_maker/dropdownitem30info';
    $heading = get_string('dropdownitem30info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem30title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem30url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem30opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    /* Dropdown Item 31 */	
    $name = 'theme_maker/dropdownitem31info';
    $heading = get_string('dropdownitem31info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem31title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem31url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem31opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Dropdown Item 32 */	
    $name = 'theme_maker/dropdownitem32info';
    $heading = get_string('dropdownitem32info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem32title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem32url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem32opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Dropdown Item 33 */	
    $name = 'theme_maker/dropdownitem33info';
    $heading = get_string('dropdownitem33info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem33title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem33url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem33opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Dropdown Item 34 */	
    $name = 'theme_maker/dropdownitem34info';
    $heading = get_string('dropdownitem34info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem34title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem34url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem34opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Dropdown Item 35 */	
    $name = 'theme_maker/dropdownitem35info';
    $heading = get_string('dropdownitem35info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem35title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem35url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem35opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Dropdown Item 36 */	
    $name = 'theme_maker/dropdownitem36info';
    $heading = get_string('dropdownitem36info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem36title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem36url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem36opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Dropdown Item 37 */	
    $name = 'theme_maker/dropdownitem37info';
    $heading = get_string('dropdownitem37info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem37title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem37url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem37opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Dropdown Item 38 */	
    $name = 'theme_maker/dropdownitem38info';
    $heading = get_string('dropdownitem38info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem38title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem38url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem38opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Dropdown Item 39 */	
    $name = 'theme_maker/dropdownitem39info';
    $heading = get_string('dropdownitem39info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem39title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem39url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem39opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    /* Dropdown Item 40 */	
    $name = 'theme_maker/dropdownitem40info';
    $heading = get_string('dropdownitem40info', 'theme_maker');
    $information = get_string('dropdownitemdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
	
	$name = 'theme_maker/dropdownitem40title';
    $title = get_string('dropdownitemtitle', 'theme_maker');
    $description = get_string('dropdownitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $name = 'theme_maker/dropdownitem40url';
    $title = get_string('dropdownitemurl', 'theme_maker');
    $description = get_string('dropdownitemurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);    
    
    $name = 'theme_maker/dropdownitem40opennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    
    //$settings->add($page);
    
    $ADMIN->add('theme_maker', $page);