<?php

class Advent72 {
    var $values = array();
    var $expressions = array();

    public function read_file() {
        // Read the file and divide the parts
        $fp = fopen('input.txt', 'r');

        while ($line = trim(fgets($fp))) {
            $parts = explode(' -> ', $line);
            
            if (!isset($this->values[$parts[1]])) {
                if (is_numeric($parts[0])) {
                    // A given value!
                    $this->values[$parts[1]] = (int)$parts[0];
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
                    $this->expressions[] = $expression;
                }
            }
        }

        fclose($fp);
    }

    public function calculate($var) {
        // Calculate the wires
        while (!isset($this->values[$var])) {
            $to_calculate = sizeof($this->expressions);

            for ($i = 0; $i < $to_calculate; $i++) {
                // Can we enter some variables?
                if (!is_numeric($this->expressions[$i]['input1']) && isset($this->values[$this->expressions[$i]['input1']])) {
                    $this->expressions[$i]['input1'] = (int)$this->values[$this->expressions[$i]['input1']];
                }
                if (isset($this->expressions[$i]['input2']) && !is_numeric($this->expressions[$i]['input2']) && isset($this->values[$this->expressions[$i]['input2']])) {
                    $this->expressions[$i]['input2'] = (int)$this->values[$this->expressions[$i]['input2']];
                }
                
                // Can we calculate?
                if (is_numeric($this->expressions[$i]['input1'])) {
                    if (isset($this->expressions[$i]['input2'])) {
                        if (is_numeric($this->expressions[$i]['input2'])) {
                            // Two numeric values. Calculate!
                            switch ($this->expressions[$i]['action']) {
                                case 'AND':
                                    $output = $this->expressions[$i]['input1'] & $this->expressions[$i]['input2'];
                                    break;
                                case 'OR':
                                    $output = $this->expressions[$i]['input1'] | $this->expressions[$i]['input2'];
                                    break;
                                case 'LSHIFT':
                                    $output = $this->expressions[$i]['input1'] << $this->expressions[$i]['input2'];
                                    break;
                                case 'RSHIFT':
                                    $output = $this->expressions[$i]['input1'] >> $this->expressions[$i]['input2'];
                                    break;
                            }
                            $this->values[$this->expressions[$i]['output']] = $output;
                            unset($this->expressions[$i]);
                        }
                    } else {
                        // One numeric only.
                        if ($this->expressions[$i]['action'] == 'NOT') {
                            // Calculate the NOT-function
                            $output = 65536 + ~(int)($this->expressions[$i]['input1']);
                            $this->values[$this->expressions[$i]['output']] = $output;
                            unset($this->expressions[$i]);
                        } else {
                            // No action
                            $this->values[$this->expressions[$i]['output']] = $this->expressions[$i]['input1'];
                        }
                    }
                }
            }
            $this->expressions = array_values($this->expressions);
        }
    }
    
    public function calculate_value($var) {
        $this->calculate($var);
        return $this->values[$var];
    }
    
    public function clear() {
        $this->values = array();
        $this->expressions = array();
    }
    
    public function set_value($name, $value) {
        $this->values[$name] = $value;
    }
}

$a = new Advent72();
$a->read_file();
$value = $a->calculate_value('a');

$a->clear();
$a->set_value('b', $value);
$a->read_file();
echo $a->calculate_value('a');