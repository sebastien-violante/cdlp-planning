<?php

namespace App\tests\Entity;

use App\Entity\Client;
use PHPUnit\Exception;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {
    public function testClientCleanedAttribute() {
        $client = new Client();
               $this->assertSame(false, $client->isCleaned(),'erreur de test');
        
    }

}