<?php

function sa(&$la) {
    if (count($la) >= 2) {
        $temp = $la[0];
        $la[0] = $la[1];
        $la[1] = $temp;
    }
}

function sb(&$lb) {
    if (count($lb) >= 2) {
        $temp = $lb[0];
        $lb[0] = $lb[1];
        $lb[1] = $temp;
    }
}

function sc(&$la, &$lb) {
    sa($la);
    sb($lb);
}

function pa(&$la, &$lb) {
    if (!empty($lb)) {
        array_unshift($la, array_shift($lb));
    }
}

function pb(&$la, &$lb) {
    if (!empty($la)) {
        array_unshift($lb, array_shift($la));
    }
}

function ra(&$la) {
    if (count($la) > 1) {
        $first = array_shift($la);
        array_push($la, $first);
    }
}

function rb(&$lb) {
    if (count($lb) > 1) {
        $first = array_shift($lb);
        array_push($lb, $first);
    }
}

function rr(&$la, &$lb) {
    ra($la);
    rb($lb);
}

function printLists($la, $lb) {
    echo "la: " . implode(" ", $la) . "\n";
    echo "lb: " . implode(" ", $lb) . "\n";
}

$the = array_slice($argv, 1, -1);
$operations = explode(" ", end($argv));
$la = $the;
$lb = [];

foreach ($operations as $operation) {
    switch ($operation) {
        case 'sa':
            sa($la);
            break;
        case 'sb':
            sb($lb);
            break;
        case 'sc':
            sc($la, $lb);
            break;
        case 'pa':
            pa($la, $lb);
            break;
        case 'pb':
            pb($la, $lb);
            break;
        case 'ra':
            ra($la);
            break;
        case 'rb':
            rb($lb);
            break;
        case 'rr':
            rr($la, $lb);
            break;
    }
}

printLists($la, $lb);
