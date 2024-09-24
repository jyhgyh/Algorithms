<?php

require './logic.php';

class TestCase
{
  protected int $errors = 0;
  protected string $red = "\033[31m";
  protected string $reset = "\033[0m";
  protected string $green = "\033[32m";

  public function __construct(string $string) {
      $this->errors++;
      echo "{$this->red}Test failed{$this->reset}: Constructor failed\n";
      echo "\n{$this->red}{$this->errors} test failed{$this->reset}\n";
  }

  protected function assertEquals($expected, $actual, $testDescription = '')
  {
    if ($expected === $actual || eval("return $expected == $actual;")) {
      echo "{$this->green}[OK]{$this->reset} Test passed: $testDescription\n";
    } else {
      echo "{$this->red}[KO] Test failed{$this->reset}: $testDescription - Expected [$expected] but got [$actual]\n";
      $this->errors++;
    }
  }
}


class UnitTest extends TestCase
{
    public function __construct(string $string) {
    }

    public function testEvalExpr()
    {
        $this->assertEquals(3, my_eval_expr("1+2"), "Test 1: 1+2");
        $this->assertEquals(7, my_eval_expr("1+2*3"), "Test 2: 1+2*3");
        $this->assertEquals(3, my_eval_expr("(1+2)*1"), "Test 2.1: (1+2)*1");
        $this->assertEquals(3, my_eval_expr("1+2*3-4"), "Test 3: 1+2*3-4");
        $this->assertEquals(5, my_eval_expr("1+2*3-4/2"), "Test 4: 1+2*3-4/2");
        $this->assertEquals(8, my_eval_expr("4+2*3-8/4"), "Test 5: 4+2*3-8/4");
        $this->assertEquals(0, my_eval_expr("10%5"), "Test 6: 10%5");
        $this->assertEquals(14, my_eval_expr("10+2*3-4/2"), "Test 8: 10+2*3-4/2");
        $this->assertEquals(101, my_eval_expr("100+2-1"), "Test 9: 100+2-1");
        $this->assertEquals(1, my_eval_expr("10%3"), "Test 10: 10%3");
        $this->assertEquals(0, my_eval_expr("10%2"), "Test 11: 10%2");
        $this->assertEquals(25, my_eval_expr("(2+3)*(4+1)"), "Test 12: (2+3)*(4+1)");
        $this->assertEquals(15, my_eval_expr("2+(3*4+1)"), "Test 13: 2+(3*4+1)");
        $this->assertEquals(2, my_eval_expr("((2+2*4)-6)/2"), "Test 14: ((2+2*4)-6)/2");

        if ($this->errors > 1) {
            echo "\n{$this->red}{$this->errors} tests failed{$this->reset}\n";
        } elseif ($this->errors == 1) {
            echo "\n{$this->red}{$this->errors} test failed{$this->reset}\n";
        } else {
            echo "\n{$this->green}All tests passed{$this->reset}\n";
        }
    }
}

$string = $argv[1] ?? '';
$unitTest = new UnitTest($string);
$unitTest->testEvalExpr();