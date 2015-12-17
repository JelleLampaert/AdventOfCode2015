<?php

$values = array();
$expressions = array();

// Read the file and divide the parts
$fp = fopen('input.txt', 'r');

while ($line = trim(fgets($fp))) {
    $parts = explode(' -> ', $line);
    
    if (is_numeric($parts[0])) {
        // A given value!
        $values[$parts[1]] = (int)$parts[0];
    } else {
        // Save the expression
        $expressionparts = explode(' ', $parts[0]);
        $expression = array();
        switch (sizeof($expressionparts)) {
            case 1:
                $expression['action'] = '';
                $expression['input1'] = $expressionparts[0];
                break;
            case 2:
                $expression['action'] = $expressionparts[0];
                $expression['input1'] = $expressionparts[1];
                break;
            case 3:
                $expression['action'] = $expressionparts[1];
                $expression['input1'] = $expressionparts[0];
                $expression['input2'] = $expressionparts[2];
                break;
        }
        $expression['output'] = $parts[1];
        $expressions[] = $expression;
    }
}

fclose($fp);

// Calculate the wires
while (!isset($values['a'])) {
    $to_calculate = sizeof($expressions);
    echo "Expressions to calculate = " . $to_calculate . "\r\n";

    for ($i = 0; $i < $to_calculate; $i++) {
        // Can we enter some variables?
        if (!is_numeric($expressions[$i]['input1']) && isset($values[$expressions[$i]['input1']])) {
            $expressions[$i]['input1'] = (int)$values[$expressions[$i]['input1']];
        }
        if (isset($expressions[$i]['input2']) && !is_numeric($expressions[$i]['input2']) && isset($values[$expressions[$i]['input2']])) {
            $expressions[$i]['input2'] = (int)$values[$expressions[$i]['input2']];
        }
        
        // Can we calculate?
        if (is_numeric($expressions[$i]['input1'])) {
            if (isset($expressions[$i]['input2'])) {
                if (is_numeric($expressions[$i]['input2'])) {
                    // Two numeric values. Calculate!
                    switch ($expressions[$i]['action']) {
                        case 'AND':
                            $output = $expressions[$i]['input1'] & $expressions[$i]['input2'];
                            break;
                        case 'OR':
                            $output = $expressions[$i]['input1'] | $expressions[$i]['input2'];
                            break;
                        case 'LSHIFT':
                            $output = $expressions[$i]['input1'] << $expressions[$i]['input2'];
                            break;
                        case 'RSHIFT':
                            $output = $expressions[$i]['input1'] >> $expressions[$i]['input2'];
                            break;
                    }
                    $values[$expressions[$i]['output']] = $output;
                    unset($expressions[$i]);
                }
            } else {
                // One numeric only.
                if ($expressions[$i]['action'] == 'NOT') {
                    // Calculate the NOT-function
                    $output = 65536 + ~(int)($expressions[$i]['input1']);
                    $values[$expressions[$i]['output']] = $output;
                    unset($expressions[$i]);
                } else {
                    // No action
                    $values[$expressions[$i]['output']] = $expressions[$i]['input1'];
                }
            }
        }
    }
    $expressions = array_values($expressions);
}

echo $values['a'];