<?php

/*
 * This file is part of Waffler.
 *
 * (c) Erick Johnson Almeida de Menezes <erickmenezes.dev@gmail.com>
 *
 * This source file is subject to the MIT licence that is bundled
 * with this source code in the file LICENCE.
 */

namespace Waffler\Tests\Fixtures\Interfaces;

use Waffler\Attributes\Request\Path;
use Waffler\Attributes\Request\PathParam;
use Waffler\Attributes\Utils\NestedResource;
use Waffler\Attributes\Verbs\Get;

/**
 * Interface ProxyTestClientInterface.
 *
 * This interface is intended for doing the tests for the {@see \Waffler\Tests\Unit\Client\ProxyTest proxy test}.
 *
 * @author ErickJMenezes <erickmenezes.dev@gmail.com>
 */
interface ProxyTestClientInterface
{
    #[Get('{bar}/{baz}')]
    public function foo(#[PathParam] string $bar, #[PathParam] string $baz): void;

    #[NestedResource]
    public function invalidNestedResource(): string;

    #[NestedResource]
    public function invalidNestedResource2();

    #[NestedResource]
    public function validNestedResource(): ProxyTestClientInterface;

    #[Path('{foo}')]
    #[NestedResource]
    public function validNestedResourceWithPath(#[PathParam] string $foo): ProxyTestClientInterface;
}
