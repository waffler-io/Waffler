<?php

/*
 * This file is part of Waffler.
 *
 * (c) Erick Johnson Almeida de Menezes <erickmenezes.dev@gmail.com>
 *
 * This source file is subject to the MIT licence that is bundled
 * with this source code in the file LICENCE.
 */

namespace Waffler\Tests\Feature\Attributes\Request;

use Waffler\Tests\Tools\FeatureTestCase;

/**
 * Class BodyTest.
 *
 * @author ErickJMenezes <erickmenezes.dev@gmail.com>
 * @coversNothing
 */
class BodyTest extends FeatureTestCase
{
    public function testRequestMustHaveBody(): void
    {
        $body = 'foo bar baz';
        $this->createRequestExpectation()
            ->expectBody($body)
            ->build()
            ->client
            ->testBody($body);
    }
}
