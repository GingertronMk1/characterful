<?php

namespace App\Domain\Common;

/**
 * @template TItemType
 *
 * @implements \Iterator<int, TItemType>
 */
abstract class AbstractCollection implements \Iterator, \Countable
{
    /**
     * @param array<TItemType> $items
     */
    final public function __construct(
        protected array $items = [],
        protected int $position = 0,
    ) {}

    abstract public static function getClassName(): string;

    /**
     * @param array<mixed> $data
     */
    final public static function fromIterable(iterable $data, ?\Closure $mapFn = null): static
    {
        $returnVal = new static();
        foreach ($data as $item) {
            $processedItem = null === $mapFn ? $item : $mapFn($item);
            if ($processedItem::class === static::getClassName()) {
                $returnVal->items[] = $processedItem;
            } else {
                throw new \InvalidArgumentException(
                    \sprintf(
                        'Tried to create a collection of `%s`, but received an invalid item.',
                        static::getClassName(),
                    )
                );
            }
        }

        return $returnVal;
    }

    public function current(): mixed
    {
        return $this->items[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->items[$this->position]);
    }

    /**
     * @return array<TItemType>
     */
    public function toArray(): array
    {
        return iterator_to_array($this);
    }

    public function filter(callable $callback): static
    {
        return static::fromIterable(
            array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH)
        );
    }

    /**
     * @return ?TItemType
     */
    public function find(callable $callback): mixed
    {
        foreach ($this->items as $item) {
            if ($callback($item)) {
                return $item;
            }
        }

        return null;
    }

    public function count(): int
    {
        return \count($this->items);
    }
}
