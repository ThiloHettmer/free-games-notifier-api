<?php

use Behat\Behat\Context\Context;

/**
 * Class fileContext
 */
class fileContext implements Context
{
    /**
     * @Given there is a file :arg1
     * @param $arg1
     * @throws Exception
     */
    public function checkIfFileExists($arg1): void
    {
        if (!file_exists($this->getProjectPath() . $arg1)) {
            throw new Exception('File: '.$arg1.' does not exist');
        }
    }

    /**
     * @return string
     */
    public function getProjectPath(): string
    {
        return __DIR__ . '/../../../';
    }
}
