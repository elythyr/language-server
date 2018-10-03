<?php

namespace Phpactor\LanguageServer\Tests\Unit\Extension\Core\Handler;

use Phpactor\LanguageServer\Core\Exception\ShutdownServer;
use Phpactor\LanguageServer\Core\Handler;
use Phpactor\LanguageServer\Extension\Core\Shutdown;

class ShutdownTest extends HandlerTestCase
{
    public function handler(): Handler
    {
        return new Shutdown();
    }

    public function testResetsConnectionOnExit()
    {
        $this->expectException(ShutdownServer::class);
        $this->dispatch('shutdown', []);
    }
}
