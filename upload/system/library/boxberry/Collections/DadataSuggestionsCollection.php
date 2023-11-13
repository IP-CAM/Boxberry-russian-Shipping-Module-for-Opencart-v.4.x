<?php

namespace boxberry\Collections;

use Boxberry\Collections\Exceptions\BadValueException;
use Boxberry\Models\DadataSuggestions;
use Exception;

class DadataSuggestionsCollection extends Collection
{
    /**
     * DadataSuggestionsIterator constructor.
     * @param array $data
     * @throws BadValueException
     * @throws Exception
     */
    public function __construct($data)
    {
        if (is_array($data)&&!empty($data)) {
            foreach ($data as $key => $value)
            {
                $this->offsetSet($key, new DadataSuggestions($value));
            }
        }
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @throws BadValueException
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof DadataSuggestions) {
            throw new BadValueException();
        }
        if (is_null($offset)) {
            $this->_container[] = $value;
        } else {
            $this->_container[$offset] = $value;
        }
    }
}