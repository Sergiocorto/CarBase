<?php

namespace Tests\Unit;

use App\Http\Services\VinCodeDecoder;
use Mockery;
use PHPUnit\Framework\TestCase;

class VinCodeDecoderTest extends TestCase
{
    public function testVinCodeDecode()
    {
        $vinCode = '5NPE24AFXFH183476';

        $expectedData = [
            'make' => 'HYUNDAI',
            'model' => 'Sonata',
            'model_year' => '2015',
        ];

        $result = VinCodeDecoder::vinCodeDecode($vinCode);

        $this->assertEquals($expectedData, $result);
    }
}
