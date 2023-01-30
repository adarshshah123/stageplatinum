<?php   
    
    
    
    defined('MOODLE_INTERNAL') || die();
	
	/* Frontpage CTA Section */
	$page = new admin_settingpage('theme_maker_ctasection', get_string('ctasectionheading', 'theme_maker'));
	$page->add(new admin_setting_heading('theme_maker_ctasectionheadingsub', get_string('ctasectionheadingsub', 'theme_maker'),
            format_text(get_string('ctasectionheadingsubdesc' , 'theme_maker'), FORMAT_MARKDOWN)));
    
    // Enable CTA Section
    $name = 'theme_maker/usectasection';
    $title = get_string('usectasection', 'theme_maker');
    $description = get_string('usectasectiondesc', 'theme_maker');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // CTA Section Title
    $name = 'theme_maker/ctasectiontitle';
    $title = get_string('ctasectiontitle', 'theme_maker');
    $description = get_string('ctasectiontitledesc', 'theme_maker');
    $default = 'Ready to learn new skills online?';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // CTA Section Content
    $name = 'theme_maker/ctasectioncontent';
    $title = get_string('ctasectioncontent', 'theme_maker');
    $description = get_string('ctasectioncontentdesc', 'theme_maker');
    $default = '<p>You can access your courses on your computer, mobile or tablets. This is the perfect training solution for businesses, universities, government, and more. Lorem ipsum dolor sit amet, consectetuer adipiscing elit <a href="#">link example</a> aenean commodo ligula eget dolor.</p>';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // CTA Section CTA Button Text
    $name = 'theme_maker/ctasectionbuttontext';
    $title = get_string('ctasectionbuttontext', 'theme_maker');
    $description = get_string('ctasectionbuttontextdesc', 'theme_maker');
    $default = 'Join Now';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // CTA Section CTA Button URL
    $name = 'theme_maker/ctasectionbuttonurl';
    $title = get_string('ctasectionbuttonurl', 'theme_maker');
    $description = get_string('ctasectionbuttonurldesc', 'theme_maker');
    $default = '#link';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // URL open in new window    
    $name = 'theme_maker/ctasectionbuttonurlopennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // Data Box Info
    $name = 'theme_maker/ctadataboxinfo';
    $heading = get_string('ctadataboxinfo', 'theme_maker');
    $information = get_string('ctadataboxinfodesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Enable Data Box 
    $name = 'theme_maker/usectadatabox';
    $title = get_string('usectadatabox', 'theme_maker');
    $description = get_string('usectadataboxdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // CTA Data Box Item 1 Title
    $name = 'theme_maker/ctadataitem1title';
    $title = get_string('ctadataitem1title', 'theme_maker');
    $description = get_string('ctadataitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // CTA Data Box Item 1 Meta
    $name = 'theme_maker/ctadataitem1meta';
    $title = get_string('ctadataitem1meta', 'theme_maker');
    $description = get_string('ctadataitemmetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // CTA Data Box Item 2 Title
    $name = 'theme_maker/ctadataitem2title';
    $title = get_string('ctadataitem2title', 'theme_maker');
    $description = get_string('ctadataitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // CTA Data Box Item 2 Meta
    $name = 'theme_maker/ctadataitem2meta';
    $title = get_string('ctadataitem2meta', 'theme_maker');
    $description = get_string('ctadataitemmetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // CTA Data Box Item 3 Title
    $name = 'theme_maker/ctadataitem3title';
    $title = get_string('ctadataitem3title', 'theme_maker');
    $description = get_string('ctadataitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // CTA Data Box Item 3 Meta
    $name = 'theme_maker/ctadataitem3meta';
    $title = get_string('ctadataitem3meta', 'theme_maker');
    $description = get_string('ctadataitemmetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // CTA Data Box Item 4 Title
    $name = 'theme_maker/ctadataitem4title';
    $title = get_string('ctadataitem4title', 'theme_maker');
    $description = get_string('ctadataitemtitledesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // CTA Data Box Item 4 Meta
    $name = 'theme_maker/ctadataitem4meta';
    $title = get_string('ctadataitem4meta', 'theme_maker');
    $description = get_string('ctadataitemmetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
        
    //$settings->add($page);
    
    $ADMIN->add('theme_maker', $page);