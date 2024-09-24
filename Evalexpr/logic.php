<?php

$expr = $argv[1];

function my_eval_expr($equation)
{
    $equation = preg_replace("/[^0-9+\-.*\/()%]/", "", $equation);

    return parse_expression($equation);
}

function parse_expression($equation)
{
    while (preg_match('/\(([^()]*)\)/', $equation, $matches)) {
        $equation = str_replace($matches[0], parse_expression($matches[1]), $equation);
    }

    while (preg_match('/(-?\d+\.?\d*|\d+)([*\/])(-?\d+\.?\d*|\d+)/', $equation, $matches)) {
        switch ($matches[2]) {
            case '*':
                $result = $matches[1] * $matches[3];
                break;
            case '/':
                $result = $matches[1] / $matches[3];
                break;
        }
        $equation = str_replace($matches[0], $result, $equation);
    }

    while (preg_match('/(-?\d+\.?\d*|\d+)([+\-])(-?\d+\.?\d*|\d+)/', $equation, $matches)) {
        switch ($matches[2]) {
            case '+':
                $result = $matches[1] + $matches[3];
                break;
            case '-':
                $result = $matches[1] - $matches[3];
                break;
        }
        $equation = str_replace($matches[0], $result, $equation);
    }
    return $equation;
}

$result = my_eval_expr($expr);
echo $result . "\n";

?>
