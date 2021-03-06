<?php

namespace Phpactor\LanguageServer\Core\Handler;

interface ServiceProvider extends Handler
{
    /**
     * Return a map of service names to public method names on this class.
     *
     * Services are asynchronous co-routines will be started when the
     * language server is initialized.
     *
     * The public method will be passed the MessageTransmitter to send
     * messages to the server.
     *
     * For example:
     *
     * ```
     *     public function services(): array
     *     {
     *         return [
     *             'ping' => 'pingService'
     *         ];
     *     }
     *
     *     public function pingService(): Promise
     *     {
     *         // exit immediately
     *         return new Success();
     *     }
     */
    public function services(): array;
}
