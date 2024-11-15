<?php

namespace App\Domain\Common;

abstract class AbstractCollection implements \Iterator, \ArrayAccess
{
    public function __construct(
        protected array $items = [],
        protected int $position = 0,
    ) {}

    abstract public static function getClassName(): string;

    public static function fromIterable(iterable $data, ?\Closure $mapFn = null): static
    {
        $returnVal = new static();
        foreach ($data as $item) {
            if (is_a($item, $returnVal->getClassName())) {
                $returnVal->items[] = is_null($mapFn) ? $item : $mapFn($item);
            } else {
                throw new \InvalidArgumentException('Tried to create a collection but received an invalid item');
            }
        }

        return $returnVal;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    public function current(): mixed
    {
        return current($this->items);
    }

    public function key(): mixed
    {
        return key($this->items);
    }

    public function next(): void
    {
        next($this->items);
    }

    public function rewind(): void
    {
        rewind($this->items);
    }

    public function valid(): bool
    {
        return null !== $this->key();
    }
}
