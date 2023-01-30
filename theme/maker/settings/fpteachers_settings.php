<?php
	
	defined('MOODLE_INTERNAL') || die();
	
    /* Frontpage Teachers */
   
	$page = new admin_settingpage('theme_maker_teachers', get_string('teachersheading', 'theme_maker'));
	$page->add(new admin_setting_heading('theme_maker_teachersheadingsub', get_string('teachersheadingsub', 'theme_maker'),
            format_text(get_string('teachersheadingsubdesc' , 'theme_maker'), FORMAT_MARKDOWN)));
    
    // Enable Teachers Section
    $name = 'theme_maker/useteachers';
    $title = get_string('useteachers', 'theme_maker');
    $description = get_string('useteachersdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // Teachers Section Title
    $name = 'theme_maker/teachersectiontitle';
    $title = get_string('teachersectiontitle', 'theme_maker');
    $description = get_string('teachersectiontitledesc', 'theme_maker');
    $default = 'Our Top Instructors';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    // Teachers Section CTA Button Info
    $name = 'theme_maker/teachersbuttoninfo';
    $heading = get_string('teachersbuttoninfo', 'theme_maker');
    $information = get_string('teachersbuttoninfodesc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teachers Section CTA Button Text
    $name = 'theme_maker/teachersbuttontext';
    $title = get_string('teachersbuttontext', 'theme_maker');
    $description = get_string('teachersbuttontextdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teachers Section CTA Button URL
    $name = 'theme_maker/teachersbuttonurl';
    $title = get_string('teachersbuttonurl', 'theme_maker');
    $description = get_string('teachersbuttonurldesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // URL open in new window    
    $name = 'theme_maker/teachersbuttonurlopennew';
    $title = get_string('opennew', 'theme_maker');
    $description = get_string('opennewdesc', 'theme_maker');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
       
    
    /* Teacher 1 */
    
    // Description for Teacher 1
    $name = 'theme_maker/teacher1info';
    $heading = get_string('teacher1', 'theme_maker');
    $information = get_string('teacher1desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher1image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher1image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher1name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = 'Steve Doe';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher1meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = 'Professor';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher1content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '<p>Teacher bio 1 goes here. You can add up to 10 teachers. Lorem ipsum dolor sit amet consectetur adipiscing elit. Integer suscipit, elit sed placerat aliquam, velit nulla semper lectus.</p>';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Teacher 2 */
    
    // Description for Teacher 2
    $name = 'theme_maker/teacher2info';
    $heading = get_string('teacher2', 'theme_maker');
    $information = get_string('teacher2desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher2image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher2image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher2name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = 'Kate Doe';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher2meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = 'Senior Lecturer';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher2content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '<p>Teacher bio 2 goes here. You can add up to 10 teachers. Lorem ipsum dolor sit amet consectetur adipiscing elit. Integer suscipit, elit sed placerat aliquam, velit nulla semper lectus.</p>';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Teacher 3 */
    
    // Description for Teacher 3
    $name = 'theme_maker/teacher3info';
    $heading = get_string('teacher3', 'theme_maker');
    $information = get_string('teacher3desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher3image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher3image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher3name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher3meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher3content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Teacher 4 */
    
    // Description for Teacher 4
    $name = 'theme_maker/teacher4info';
    $heading = get_string('teacher4', 'theme_maker');
    $information = get_string('teacher4desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher4image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher4image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher4name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher4meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher4content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Teacher 5 */
    
    // Description for Teacher 5
    $name = 'theme_maker/teacher5info';
    $heading = get_string('teacher5', 'theme_maker');
    $information = get_string('teacher5desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher5image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher5image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher5name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher5meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher5content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Teacher 6 */
    
    // Description for Teacher 6
    $name = 'theme_maker/teacher6info';
    $heading = get_string('teacher6', 'theme_maker');
    $information = get_string('teacher6desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher6image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher6image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher6name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher6meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher6content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Teacher 7 */
    
    // Description for Teacher 7
    $name = 'theme_maker/teacher7info';
    $heading = get_string('teacher7', 'theme_maker');
    $information = get_string('teacher7desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher7image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher7image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher7name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher7meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher7content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Teacher 8 */
    
    // Description for Teacher 8
    $name = 'theme_maker/teacher8info';
    $heading = get_string('teacher8', 'theme_maker');
    $information = get_string('teacher8desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher8image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher8image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher8name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher8meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher8content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Teacher 9 */
    
    // Description for Teacher 9
    $name = 'theme_maker/teacher9info';
    $heading = get_string('teacher9', 'theme_maker');
    $information = get_string('teacher9desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher9image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher9image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher9name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher9meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher9content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Teacher 10 */
    
    // Description for Teacher 10
    $name = 'theme_maker/teacher10info';
    $heading = get_string('teacher10', 'theme_maker');
    $information = get_string('teacher10desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher10image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher10image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher10name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher10meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher10content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    /* Teacher 11 */
    
    // Description for Teacher 11
    $name = 'theme_maker/teacher11info';
    $heading = get_string('teacher11', 'theme_maker');
    $information = get_string('teacher11desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher11image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher11image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher11name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher11meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher11content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Teacher 12 */
    
    // Description for Teacher 12
    $name = 'theme_maker/teacher12info';
    $heading = get_string('teacher12', 'theme_maker');
    $information = get_string('teacher12desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher12image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher12image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher12name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher12meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher12content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Teacher 13 */
    
    // Description for Teacher 13
    $name = 'theme_maker/teacher13info';
    $heading = get_string('teacher13', 'theme_maker');
    $information = get_string('teacher13desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher13image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher13image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher13name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher13meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher13content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Teacher 14 */
    
    // Description for Teacher 14
    $name = 'theme_maker/teacher14info';
    $heading = get_string('teacher14', 'theme_maker');
    $information = get_string('teacher14desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher14image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher14image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher14name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher14meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher14content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Teacher 15 */
    
    // Description for Teacher 15
    $name = 'theme_maker/teacher15info';
    $heading = get_string('teacher15', 'theme_maker');
    $information = get_string('teacher15desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher15image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher15image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher15name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher15meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher15content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Teacher 16 */
    
    // Description for Teacher 16
    $name = 'theme_maker/teacher16info';
    $heading = get_string('teacher16', 'theme_maker');
    $information = get_string('teacher16desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher16image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher16image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher16name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher16meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher16content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Teacher 17 */
    
    // Description for Teacher 17
    $name = 'theme_maker/teacher17info';
    $heading = get_string('teacher17', 'theme_maker');
    $information = get_string('teacher17desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher17image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher17image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher17name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher17meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher17content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Teacher 18 */
    
    // Description for Teacher 18
    $name = 'theme_maker/teacher18info';
    $heading = get_string('teacher18', 'theme_maker');
    $information = get_string('teacher18desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher18image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher18image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher18name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher18meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher18content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Teacher 19 */
    
    // Description for Teacher 19
    $name = 'theme_maker/teacher19info';
    $heading = get_string('teacher19', 'theme_maker');
    $information = get_string('teacher19desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher19image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher19image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher19name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher19meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher19content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    /* Teacher 20 */
    
    // Description for Teacher 20
    $name = 'theme_maker/teacher20info';
    $heading = get_string('teacher20', 'theme_maker');
    $information = get_string('teacher20desc', 'theme_maker');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    
    // Teacher Image 
    $name = 'theme_maker/teacher20image';
    $title = get_string('teacherimage', 'theme_maker');
    $description = get_string('teacherimagedesc', 'theme_maker');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'teacher20image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Name
    $name = 'theme_maker/teacher20name';
    $title = get_string('teachername', 'theme_maker');
    $description = get_string('teachernamedesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Profile Meta
    $name = 'theme_maker/teacher20meta';
    $title = get_string('teachermeta', 'theme_maker');
    $description = get_string('teachermetadesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Teacher Content 
    $name = 'theme_maker/teacher20content';
    $title = get_string('teachercontent', 'theme_maker');
    $description = get_string('teachercontentdesc', 'theme_maker');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    
    //$settings->add($page);
    
    $ADMIN->add('theme_maker', $page);