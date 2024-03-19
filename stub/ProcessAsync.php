<?php

/**
 * process_async 関数のためのクラススタブ
 *
 * @used-by \process_async()
 * @used-by \ryunosuke\Functions\process_async()
 * @used-by \ryunosuke\Functions\Package\process_async()
 */
class ProcessAsync
{
    public array  $status;
    public string $stdout;
    public string $stderr;

    public function __invoke() { }

    public function setDestructAction($action) { }

    public function setCompleteAction($action) { }

    public function update() { }

    public function status() { }

    public function terminate() { }
}
