<?php 
	
	
	defined('MOODLE_INTERNAL') || die();
	
	
	/* Frontpage Benefits */
	$page = new admin_settingpage('theme_maker_benefits', get_string('benefitsheading', 'theme_maker'));
	
	$page->add(new admin_setting_heading('theme_maker_benefitsheadingsub', get_string('benefitsheadingsub', 'theme_maker'),
            format_text(get_string('benefitsheadingsubdesc' , 'theme_maker'), FORMAT_MARKDOWN)));
    
    // Enable Benefits Section
    $name = 'theme_maker/usebenefits';
    $title = get_string('usebenefits', 'theme_maker');
    $description = get_string('usebenefitsdesc', 'theme_maker');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // Benefits Section CTA Button Info
    $name = 'theme_maker/benefitsbuttoninfo';
    $heading = get_string('benefitsbuttoninfo', 'theme_maker');
    $information = get_string('benefitsbuttoninfodesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Benefits Section CTA Button Text
    $name = 'theme_maker/benefitsbuttontext';
    $title = get_string('benefitsbuttontext', 'theme_maker');
    $description = get_string('benefitsbuttontextdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Benefits Section CTA Button URL
    $name = 'theme_maker/benefitsbuttonurl';
    $title = get_string('benefitsbuttonurl', 'theme_maker');
    $description = get_string('benefitsbuttonurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // URL open in new window    
    $name = 'theme_maker/benefitsbuttonurlopennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
     
    // PLATINUM EDIT
    // BENEFIT TITLE HEADER
    $name = 'theme_maker/benefittsitleheader';
    $heading = get_string('benefitstitleheader', 'theme_maker');
    $information = get_string('benefitstitleheaderdesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);

    // BENEFIT TITLE TEXT
    $name = 'theme_maker/benefitstitle';
    $title = get_string('benefitstitle', 'theme_maker');
    $description = get_string('benefitstitle', 'theme_maker');
    $default = 'Our Incredible Features';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // END PLATINUM EDIT
    // Benefit 1
    
    // Description
    $name = 'theme_maker/benefit1info';
    $heading = get_string('benefit1info', 'theme_maker');
    $information = get_string('benefit1desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Icon
    $name = 'theme_maker/benefit1icon';
    $title = get_string('benefit1icon', 'theme_maker');
    $description = get_string('benefit1icondesc', 'theme_maker');    
    $default = 'important_devices';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // Use Image Instead of Icon
    $name = 'theme_maker/usebenefit1image';
    $title = get_string('usebenefitimage', 'theme_maker');
    $description = get_string('usebenefitimagedesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // Image 
    $name = 'theme_maker/benefit1image';
    $title = get_string('benefitimage', 'theme_maker');
    $description = get_string('benefitimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'benefit1image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // Title
    $name = 'theme_maker/benefit1title';
    $title = get_string('benefit1title', 'theme_maker');
    $description = get_string('benefit1titledesc', 'theme_maker');
    $default = 'Benefit One';
    $setting = new admin_setting_configtext($name, $title, $description, $default);    
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Content
    $name = 'theme_maker/benefit1content';
    $title = get_string('benefit1copy', 'theme_maker');
    $description = get_string('benefit1contentdesc', 'theme_maker');
    $default = '<p>Outline a benefit here. You can change the icon above to any of the 900+ <a href="https://material.io/icons/" target="_blank">Google Material icons</a> available. You can add up to 6 benefit blocks in this section.</p>';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Benefit 2
    
    // Description
    $name = 'theme_maker/benefit2info';
    $heading = get_string('benefit2info', 'theme_maker');
    $information = get_string('benefit2desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Icon
    $name = 'theme_maker/benefit2icon';
    $title = get_string('benefit2icon', 'theme_maker');
    $description = get_string('benefit2icondesc', 'theme_maker');
    $default = 'verified_user';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Use Image Instead of Icon
    $name = 'theme_maker/usebenefit2image';
    $title = get_string('usebenefitimage', 'theme_maker');
    $description = get_string('usebenefitimagedesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // Image 
    $name = 'theme_maker/benefit2image';
    $title = get_string('benefitimage', 'theme_maker');
    $description = get_string('benefitimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'benefit2image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Title
    $name = 'theme_maker/benefit2title';
    $title = get_string('benefit2title', 'theme_maker');
    $description = get_string('benefit2titledesc', 'theme_maker');
    $default = 'Benefit Two';
    $setting = new admin_setting_configtext($name, $title, $description, $default);    
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Content
    $name = 'theme_maker/benefit2content';
    $title = get_string('benefit2copy', 'theme_maker');
    $description = get_string('benefit2contentdesc', 'theme_maker');
    $default = '<p>Outline a benefit here. You can change the icon above to any of the 900+ <a href="https://material.io/icons/" target="_blank">Google Material icons</a> available. You can add up to 6 benefit blocks in this section.</p>';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Benefit 3
    
    // Description
    $name = 'theme_maker/benefit3info';
    $heading = get_string('benefit3info', 'theme_maker');
    $information = get_string('benefit3desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Icon
    $name = 'theme_maker/benefit3icon';
    $title = get_string('benefit3icon', 'theme_maker');
    $description = get_string('benefit3icondesc', 'theme_maker');
    $default = 'all_inclusive';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Use Image Instead of Icon
    $name = 'theme_maker/usebenefit3image';
    $title = get_string('usebenefitimage', 'theme_maker');
    $description = get_string('usebenefitimagedesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // Image 
    $name = 'theme_maker/benefit3image';
    $title = get_string('benefitimage', 'theme_maker');
    $description = get_string('benefitimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'benefit3image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Title
    $name = 'theme_maker/benefit3title';
    $title = get_string('benefit3title', 'theme_maker');
    $description = get_string('benefit3titledesc', 'theme_maker');
    $default = 'Benefit Three';
    $setting = new admin_setting_configtext($name, $title, $description, $default);    
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Content
    $name = 'theme_maker/benefit3content';
    $title = get_string('benefit3copy', 'theme_maker');
    $description = get_string('benefit3contentdesc', 'theme_maker');
    $default = '<p>Outline a benefit here. You can change the icon above to any of the 900+ <a href="https://material.io/icons/" target="_blank">Google Material icons</a> available. You can add up to 6 benefit blocks in this section.</p>';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Benefit 4
    
    // Description
    $name = 'theme_maker/benefit4info';
    $heading = get_string('benefit4info', 'theme_maker');
    $information = get_string('benefit4desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Icon
    $name = 'theme_maker/benefit4icon';
    $title = get_string('benefit4icon', 'theme_maker');
    $description = get_string('benefit4icondesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Use Image Instead of Icon
    $name = 'theme_maker/usebenefit4image';
    $title = get_string('usebenefitimage', 'theme_maker');
    $description = get_string('usebenefitimagedesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // Image 
    $name = 'theme_maker/benefit4image';
    $title = get_string('benefitimage', 'theme_maker');
    $description = get_string('benefitimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'benefit4image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Title
    $name = 'theme_maker/benefit4title';
    $title = get_string('benefit4title', 'theme_maker');
    $description = get_string('benefit4titledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);    
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Content
    $name = 'theme_maker/benefit4content';
    $title = get_string('benefit4copy', 'theme_maker');
    $description = get_string('benefit4contentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Benefit 5
    
    // Description
    $name = 'theme_maker/benefit5info';
    $heading = get_string('benefit5info', 'theme_maker');
    $information = get_string('benefit5desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Icon
    $name = 'theme_maker/benefit5icon';
    $title = get_string('benefit5icon', 'theme_maker');
    $description = get_string('benefit5icondesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // Use Image Instead of Icon
    $name = 'theme_maker/usebenefit5image';
    $title = get_string('usebenefitimage', 'theme_maker');
    $description = get_string('usebenefitimagedesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // Image 
    $name = 'theme_maker/benefit5image';
    $title = get_string('benefitimage', 'theme_maker');
    $description = get_string('benefitimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'benefit5image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Title
    $name = 'theme_maker/benefit5title';
    $title = get_string('benefit5title', 'theme_maker');
    $description = get_string('benefit5titledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);    
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Content
    $name = 'theme_maker/benefit5content';
    $title = get_string('benefit5copy', 'theme_maker');
    $description = get_string('benefit5contentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    // Benefit 6
    
    // Description
    $name = 'theme_maker/benefit6info';
    $heading = get_string('benefit6info', 'theme_maker');
    $information = get_string('benefit6desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Icon
    $name = 'theme_maker/benefit6icon';
    $title = get_string('benefit6icon', 'theme_maker');
    $description = get_string('benefit6icondesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Use Image Instead of Icon
    $name = 'theme_maker/usebenefit6image';
    $title = get_string('usebenefitimage', 'theme_maker');
    $description = get_string('usebenefitimagedesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // Image 
    $name = 'theme_maker/benefit6image';
    $title = get_string('benefitimage', 'theme_maker');
    $description = get_string('benefitimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'benefit6image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // Title
    $name = 'theme_maker/benefit6title';
    $title = get_string('benefit6title', 'theme_maker');
    $description = get_string('benefit6titledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);    
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Content
    $name = 'theme_maker/benefit6content';
    $title = get_string('benefit6copy', 'theme_maker');
    $description = get_string('benefit6contentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);  
	
	
	//$settings->add($page);
    
    $ADMIN->add('theme_maker', $page);