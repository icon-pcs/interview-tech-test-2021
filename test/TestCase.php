<?php declare(strict_types=1);

namespace IconLanguageServices\ApiClient\Test;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class TestCase extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    protected function assertPostConditions(): void
    {
        $this->mockeryAssertPostConditions();
    }
}
