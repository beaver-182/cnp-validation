<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require __DIR__.'/../src/validation.php';

class CnpTest extends TestCase
{
    public function testCnpIsValid()
    {
        //test 100 random cnps
        for ($i = 1; $i <= 100; $i++) {
            $generatedCnp = generateCnp();
            $result = isCnpValid($generatedCnp);
            $this->assertTrue($result);
        }
    }

    public function testCnpIsInvalid()
    {
        //generate cnp and increment it
        $code = generateCnp();
        $result = isCnpValid((string) ++$code);
        $this->assertFalse($result);

        //remove last character
        $code = generateCnp();
        $result = isCnpValid(substr($code, 0,-1));
        $this->assertFalse($result);

        //check cnp with invalid date
        $code = '1990230317692';
        $result = isCnpValid($code);
        $this->assertFalse($result);
    }
}
