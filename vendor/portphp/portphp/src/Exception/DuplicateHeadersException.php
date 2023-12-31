<?php

namespace Port\Exception;

/**
 * @author David de Boer <david@ddeboer.nl>
 */
class DuplicateHeadersException extends ReaderException
{
    /**
     * @param array $duplicates
     */
    public function __construct($duplicates)
    {
        parent::__construct(sprintf('File contains duplicate headers: %s', implode(', ', $duplicates)));
    }
}
