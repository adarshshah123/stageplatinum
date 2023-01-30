<?php

defined('MOODLE_INTERNAL') || die();

user_preference_allow_ajax_update('drawer-open-nav', PARAM_ALPHA);
require_once($CFG->libdir . '/behat/lib.php');



// Add block button in editing mode.
$addblockbutton = $OUTPUT->addblockbutton();


$extraclasses = [];
$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$blockshtml = $OUTPUT->blocks('side-pre');
$blockshtmlcenterpre =  $OUTPUT->blocks('center-pre');
$blockshtmlcenterpost =  $OUTPUT->blocks('center-post');

$hasblocks = (strpos($blockshtml, 'data-block=') !== false || !empty($addblockbutton));
$hasblockscenterpre = (strpos($blockshtmlcenterpre, 'data-block=') !== false || !empty($addblockbutton));
$hasblockscenterpost = (strpos($blockshtmlcenterpost, 'data-block=') !== false || !empty($addblockbutton));


$secondarynavigation = false;
if ($PAGE->has_secondary_navigation()) {
    $tablistnav = $PAGE->has_tablist_secondary_navigation();
    $moremenu = new \core\navigation\output\more_menu($PAGE->secondarynav, 'nav-tabs', true, $tablistnav);
    $secondarynavigation = $moremenu->export_for_template($OUTPUT);
    $overflowdata = $PAGE->secondarynav->get_overflow_menu_data();
    if (!is_null($overflowdata)) {
        $overflow = $overflowdata->export_for_template($OUTPUT);
    }
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
    'usermenu' => $primarymenu['user'],
    'langmenu' => $primarymenu['lang'],
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    
    'headercontent' => $headercontent,
    'overflow' => $overflow,
    'addblockbutton' => $addblockbutton,
];

$PAGE->requires->jquery ();
$PAGE->requires->js('/theme/maker/plugins/back-to-top.js');


echo $OUTPUT->render_from_template('theme_maker/columns2', $templatecontext);

