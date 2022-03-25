<?php

declare(strict_types=1);

namespace Kommai;

use ArrayAccess;
use BadMethodCallException;
use Closure;
use OutOfBoundsException;

class Container implements ArrayAccess
{
    private array $cache = [];
    private array $definitions;

    public function __construct(array $definitions)
    {
        $this->definitions = $definitions;
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->definitions);
    }

    public function get(string $id): mixed
    {
        if (!$this->has($id)) {
            throw new OutOfBoundsException(sprintf('"%s" does not exist', $id));
        }
        if (!$this->definitions[$id] instanceof Closure) {
            return $this->definitions[$id];
        }
        if (!isset($this->cache[$id])) {
            $this->cache[$id] = call_user_func($this->definitions[$id], $this);
        }
        return $this->cache[$id];
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->has((string) $offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get((string) $offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new BadMethodCallException('Not allowed to set');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new BadMethodCallException('Not allowed to unset');
    }
}
