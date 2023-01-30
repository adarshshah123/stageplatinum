<?php


defined('MOODLE_INTERNAL') || die();

$bodyattributes = $OUTPUT->body_attributes($extraclasses);

//$bodyattributes = $OUTPUT->body_attributes([]);

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,
    'gridicon' => $OUTPUT->image_url('grid-icon-inverse', 'theme'),
    
];

if (empty($PAGE->layout_options['noactivityheader'])) {
    $header = $PAGE->activityheader;
    $renderer = $PAGE->get_renderer('core');
    $templatecontext['headercontent'] = $header->export_for_template($renderer);
}

$PAGE->requires->jquery ();
$PAGE->requires->js('/theme/maker/plugins/back-to-top.js');

echo $OUTPUT->render_from_template('theme_maker/columns1', $templatecontext);

