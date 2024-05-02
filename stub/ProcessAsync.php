<?php
// @formatter:off

/**
 * stub for process_async
 *
 *
 *
 * @used-by \process_async()
 * @used-by \ryunosuke\Functions\process_async()
 * @used-by \ryunosuke\Functions\Package\process_async()
 */
class ProcessAsync
{
    public $stdout;
    public $stderr;

    public function __invoke() { }
    public function setDestructAction($action): self { }
    public function setCompleteAction($action): self { }
    public function update(): bool { }
    public function status(): array { }
    public function terminate(): bool { }
}
