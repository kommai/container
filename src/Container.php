<?php

declare(strict_types=1);

namespace Kommai;

use ArrayAccess;
use Closure;
use OutOfBoundsException;

class Container implements ArrayAccess
{
    protected array $cache = [];
    protected array $items = [];

    public function dumpCache(): array
    {
        return $this->cache;
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->items);
    }

    public function get(string $id): mixed
    {
        if (!$this->has($id)) {
            throw new OutOfBoundsException(sprintf('"%s" does not exist', $id));
        }
        if (isset($this->cache[$id])) {
            return $this->cache[$id];
        }
        if ($this->items[$id] instanceof Closure) {
            return $this->cache[$id] = call_user_func($this->items[$id], $this);
        }
        return $this->cache[$id] = $this->items[$id];
    }

    protected function set(string $id, mixed $item): void
    {
        $this->items[$id] = $item;
    }

    protected function delete(string $id): void
    {
        if (!$this->has($id)) {
            throw new OutOfBoundsException(sprintf('"%s" does not exist', $id));
        }

        unset($this->items[$id]);
        if (isset($this->cache[$id])) {
            unset($this->cache[$id]);
        }
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
        // TODO: this allows outsiders to set a value; fix it
        $this->set((string) $offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        // TODO: this allows outsiders to unset a value; fix it
        $this->delete((string) $offset);
    }
}
