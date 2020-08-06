<?php

declare(strict_types=1);

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\DataService\DataReader;
use App\Service\DataService\DataValidator;

class InputTest extends TestCase
{
    public function testInvalidDate($filename = 'testInputs\badDate.csv')
    {
        $output = DataReader::readDataFromCSV($filename);
        $stringOutput = $output[0] . $output[1] ;
        $this->assertEquals($stringOutput, 'Error encountered on line 1');
    }
    public function testInvalidId($filename = 'testInputs\badID.csv')
    {
        $output = DataReader::readDataFromCSV($filename);
        $stringOutput = $output[0] . $output[1] ;
        $this->assertEquals($stringOutput, 'Error encountered on line 2');   
    }
    public function testInvalidAmount($filename = 'testInputs\badAmount.csv')
    {
        $output = DataReader::readDataFromCSV($filename);
        $stringOutput = $output[0] . $output[1] ;
        $this->assertEquals($stringOutput, 'Error encountered on line 5');
    }
    public function testInvalidLegalType($filename = 'testInputs\badLegalType.csv')
    {
        $output = DataReader::readDataFromCSV($filename);
        $stringOutput = $output[0] . $output[1] ;
        $this->assertEquals($stringOutput, 'Error encountered on line 3');
    }
    public function testInvalidOperationType($filename = 'testInputs\badOperationType.csv')
    {
        $output = DataReader::readDataFromCSV($filename);
        $stringOutput = $output[0] . $output[1] ;
        $this->assertEquals($stringOutput, 'Error encountered on line 4');
    }
    public function testInvalidCurrencyType($filename = 'testInputs\veryBadCurrencyType.csv')
    {
        $output = DataReader::readDataFromCSV($filename);
        $stringOutput = $output[0] . $output[1] ;
        $this->assertEquals($stringOutput, 'Error encountered on line 6');
    }
    
}
