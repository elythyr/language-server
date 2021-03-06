<?php

namespace Phpactor\LanguageServer\Tests\Unit;

use Phpactor\TestUtils\PHPUnit\TestCase;
use Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor\LanguageServer\Core\Server\LanguageServer;
use Phpactor\LanguageServer\LanguageServerBuilder;

class LanguageServerBuilderTest extends TestCase
{
    public function testBuild()
    {
        $server = LanguageServerBuilder::create()
            ->addSystemHandler(new class implements Handler {
                public function methods(): array
                {
                    return [];
                }
            })
            ->catchExceptions(true)
            ->tcpServer('127.0.0.1:8888')
            ->build();

        $this->assertInstanceOf(LanguageServer::class, $server);
    }

    public function testBuildWithRecorder()
    {
        $name = tempnam(sys_get_temp_dir(), 'language-server-test');
        $server = LanguageServerBuilder::create()
            ->addSystemHandler(new class implements Handler {
                public function methods(): array
                {
                    return ['foo'=>'foo'];
                }
                public function foo()
                {
                }
            })
            ->recordTo($name)
            ->buildServerTester();

        $server->dispatchAndWait(1, 'foo', ['foo' => 'bar']);
        $this->assertStringContainsString('"method":"foo","params":{"foo":"bar"},"jsonrpc":"2.0"}', file_get_contents($name));
        unlink($name);
    }
}
