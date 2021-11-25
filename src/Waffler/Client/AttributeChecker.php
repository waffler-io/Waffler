<?php

namespace Waffler\Client;

use InvalidArgumentException;
use Stringable;
use Waffler\Attributes\Auth\Basic;
use Waffler\Attributes\Auth\Bearer;
use Waffler\Attributes\Auth\Digest;
use Waffler\Attributes\Auth\Ntml;
use Waffler\Attributes\Request\FormParams;
use Waffler\Attributes\Request\HeaderParam;
use Waffler\Attributes\Request\Headers;
use Waffler\Attributes\Request\Json;
use Waffler\Attributes\Request\JsonParam;
use Waffler\Attributes\Request\Multipart;
use Waffler\Attributes\Request\PathParam;
use Waffler\Attributes\Request\Query;
use Waffler\Attributes\Request\QueryParam;
use Waffler\Attributes\Utils\RawOptions;

/**
 * Class AttributeChecker.
 *
 * @author   ErickJMenezes <erickmenezes.dev>
 * @internal For internal use only.
 */
class AttributeChecker
{
    /**
     * Checks if the attribute has the expected parameters.
     *
     * @param class-string<T> $attribute
     * @param mixed           $value
     *
     * @return void
     * @template T
     * @throws \InvalidArgumentException
     */
    public static function check(string $attribute, mixed $value): void
    {
        match ($attribute) {
            Bearer::class, PathParam::class, QueryParam::class, => self::expectsStringOrInt($value),
            Basic::class, Digest::class, Ntml::class => self::authHeaders($value),
            Query::class, Json::class, Headers::class, Multipart::class, FormParams::class, RawOptions::class => self::expectsArray(
                $value
            ),
            HeaderParam::class => self::expectsString($value),
            JsonParam::class => self::expectsStringOrIntOrArray($value),
            default => null
        };
    }

    private static function expectsStringOrInt(mixed $value): void
    {
        if (!is_string($value) && !is_a($value, Stringable::class) && !is_int($value)) {
            throw new InvalidArgumentException(
                sprintf(
                    "The attribute %s was expecting string or int, %s given.",
                    static::class,
                    gettype($value)
                )
            );
        }
    }

    private static function expectsStringOrIntOrArray(mixed $value): void
    {
        if (!is_string($value)
            && !is_a($value, Stringable::class)
            && !is_int($value)
            && !is_array($value)) {
            throw new InvalidArgumentException(
                sprintf(
                    "The attribute %s was expecting string or int, %s given.",
                    static::class,
                    gettype($value)
                )
            );
        }
    }

    private static function expectsString(mixed $value): void
    {
        if (!is_string($value) && !is_a($value, Stringable::class)) {
            throw new InvalidArgumentException(
                sprintf(
                    "The attribute %s was expecting string, %s given.",
                    static::class,
                    gettype($value)
                )
            );
        }
    }

    private static function authHeaders(mixed $value): void
    {
        if (!is_array($value) || count($value) !== 2) {
            throw new InvalidArgumentException(
                "The value of authorization must be an array with 2 values: username and password."
            );
        }
    }

    private static function expectsArray(mixed $value): void
    {
        if (!is_array($value)) {
            throw new InvalidArgumentException(
                sprintf(
                    "The attribute %s was expecting an argument of type array, %s given.",
                    static::class,
                    gettype($value)
                )
            );
        }
    }
}
