<?php

/*
 * This file is part of Waffler\Waffler.
 *
 * (c) Erick Johnson Almeida de Menezes <erickmenezes.dev@gmail.com>
 *
 * This source file is subject to the MIT licence that is bundled
 * with this source code in the file LICENCE.
 */

namespace Waffler\Waffler\Tests\Feature\Attributes\Auth;

use Waffler\Waffler\Tests\Fixtures\FeatureTestCase;

/**
 * Class DigestTest.
 *
 * @author ErickJMenezes <erickmenezes.dev@gmail.com>
 * @coversNothing
 */
class DigestTest extends FeatureTestCase
{
    public function testRequestMustHaveDigestHeader(): void
    {
        $this->createRequestExpectation()
            ->expectGuzzleOption('auth', ['a', 'b', 'digest'])
            ->build()
            ->client
            ->testDigest(['a', 'b']);
    }
}
