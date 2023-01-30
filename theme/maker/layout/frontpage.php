<?php
	

defined('MOODLE_INTERNAL') || die();

user_preference_allow_ajax_update('drawer-open-nav', PARAM_ALPHA);
require_once($CFG->libdir . '/behat/lib.php');




// Add-a-block in editing mode.
if (isset($PAGE->theme->addblockposition) &&
        $PAGE->user_is_editing() &&
        $PAGE->user_can_edit_blocks() &&
        $PAGE->pagelayout !== 'mycourses'
) {
    $url = new moodle_url($PAGE->url, ['bui_addblock' => '', 'sesskey' => sesskey()]);

    $block = new block_contents;
    $block->content = $OUTPUT->render_from_template('core/add_block_button',
        [
            'link' => $url->out(false),
            'escapedlink' => "?{$url->get_query_string(false)}",
            'pageType' => $PAGE->pagetype,
            'pageLayout' => $PAGE->pagelayout,
        ]
    );

    $PAGE->blocks->add_fake_block($block, BLOCK_POS_RIGHT);
}


//$navdraweropen = (get_user_preferences('drawer-open-nav', 'true') == 'true');
//$navdraweropen = false;


$extraclasses = [];

/* if ($navdraweropen) {
    $extraclasses[] = 'drawer-open-left';
}
*/


$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$blockshtml = $OUTPUT->blocks('side-pre');
$blockshtmlcenterpre =  $OUTPUT->blocks('center-pre');
$blockshtmlcenterpost =  $OUTPUT->blocks('center-post');

$hasblocks = strpos($blockshtml, 'data-block=') !== false;
$hasblockscenterpre = strpos($blockshtmlcenterpre, 'data-block=') !== false;
$hasblockscenterpost = strpos($blockshtmlcenterpost, 'data-block=') !== false;



$secondarynavigation = false;
if ($PAGE->has_secondary_navigation()) {
    $moremenu = new \core\navigation\output\more_menu($PAGE->secondarynav, 'nav-tabs');
    $secondarynavigation = $moremenu->export_for_template($OUTPUT);
}

$primary = new core\navigation\output\primary($PAGE);
$renderer = $PAGE->get_renderer('core');
$primarymenu = $primary->export_for_template($renderer);
$buildregionmainsettings = !$PAGE->include_region_main_settings_in_header_actions()  && !$PAGE->has_secondary_navigation();
// If the settings menu will be included in the header then don't add it here.
$regionmainsettingsmenu = $buildregionmainsettings ? $OUTPUT->region_main_settings_menu() : false;

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    
    'sidepreblocks' => $blockshtml,
	'centerpreblocks' => $blockshtmlcenterpre,
	'centerpostblocks' => $blockshtmlcenterpost,

	
	'hasblocks' => $hasblocks,
    'bodyattributes' => $bodyattributes,
    'hasblockscenterpre' => $hasblockscenterpre,
    'hasblockscenterpost' => $hasblockscenterpost,
    
    'primarymoremenu' => $primarymenu['moremenu'],
    'secondarymoremenu' => $secondarynavigation ?: false,
    'mobileprimarynav' => $primarymenu['mobileprimarynav'],


    //'navdraweropen' => $navdraweropen,
    
    
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    
    /*
    'primarymoremenu' => $primarymenu['moremenu'],
    'secondarymoremenu' => $secondarynavigation ?: false,
    'mobileprimarynav' => $primarymenu['mobileprimarynav'],
    */
    
    'usermenu' => $primarymenu['user'],
    'langmenu' => $primarymenu['lang'],
    
];

$PAGE->requires->jquery();
$PAGE->requires->js('/theme/maker/plugins/back-to-top.js');


echo $OUTPUT->render_from_template('theme_maker/frontpage', $templatecontext);