<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

// Require the initialisation file
require_once '../../init-delivery.php';

// Required files
require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';
require_once MAX_PATH . '/lib/max/Delivery/flash.php';
require_once MAX_PATH . '/lib/max/Delivery/javascript.php';

// No Caching
MAX_commonSetNoCacheHeaders();

//Register any script specific input variables
MAX_commonRegisterGlobalsArray(array('block', 'blockcampaign', 'exclude', 'mmm_fo', 'q'));

if (isset($context) && !is_array($context)) {
    $context = MAX_commonUnpackContext($context);
}
if (!is_array($context)) {
    $context = array();
}

if (isset($exclude) && $exclude != '' && $exclude != ',') {
    $exclude = explode(',', trim($exclude, ','));
    for ($i = 0; $i < count($exclude); $i++) {
        // Avoid adding empty entries and duplicates
        if ($exclude[$i] != '' && array_search(array ("!=" => $exclude[$i]), $context) === false) {
            $context[] = array ("!=" => $exclude[$i]);
        }
    }
}

// Get the banner
$output = MAX_adSelect($what, $campaignid, $target, $source, $withtext, $charset, $context, true, $ct0, $GLOBALS['loc'], $GLOBALS['referer']);

// Block this banner for next invocation
if (!empty($block) && !empty($output['bannerid'])) {
    $output['context'][] = array('!=' => 'bannerid:' . $output['bannerid']);
// Block this banner for next invocation
if (!empty($block) && !empty($output['bannerid'])) {
    $output['context'][] = array('!=' => 'bannerid:' . $output['bannerid']);
}

// Block this campaign for next invocation
if (!empty($blockcampaign) && !empty($output['campaignid'])) {
    $output['context'][] = array('!=' => 'campaignid:' . $output['campaignid']);
}
}

// Block this campaign for next invocation
if (!empty($blockcampaign) && !empty($output['campaignid'])) {
    $output['context'][] = array('!=' => 'campaignid:' . $output['campaignid']);
}
// Append any data to the context array
if (!empty($output['context'])) {
    foreach ($output['context'] as $id => $contextArray) {
        if (!in_array($contextArray, $context)) {
            $context[] = $contextArray;
        }
    }
}

$ad = $output;
var_dump($ad);