<?php

declare(strict_types=1);

namespace Foo\Bar;

use function Psl\Type\mixed;
use function Psl\Type\nullable;

final readonly class IssueHere
{
    /** @return list<array<string, mixed>> */
    private function commonConfig(): array
    {
        $defaults = nullable(mixed());

        return [
            ...$scrapeConfigs
                ->map(static fn (mixed $scrapeConfig): array => $scrapeConfig->toArray())
                ->toArray(),
        ];
    }
}
