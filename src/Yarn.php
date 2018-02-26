<?php

namespace Hammock\PHPCI;

use PHPCI\Builder;
use PHPCI\Model\Build;
use PHPCI\Plugin;
use Psr\Log\LogLevel;

class Yarn implements Plugin
{
    protected $directory;
    protected $phpci;
    protected $build;
    protected $npm;
    protected $command;
    protected $flags;

    /**
     * @param Builder $phpci
     * @param Build $build
     * @param array $options
     */
    public function __construct(Builder $phpci, Build $build, array $options = [])
    {
        $path = $phpci->buildPath;
        $this->build = $build;
        $this->phpci = $phpci;
        $this->directory = $path;
        $this->npm = $this->phpci->findBinary('yarn');
        if (array_key_exists('directory', $options)) {
            $this->directory = $path . '/' . $options['directory'];
        }
        $this->command = array_key_exists('command', $options) ? $options['command'] : null;
        $this->flags = array_key_exists('flags', $options) ? $options['flags'] : [];
    }

    /**
     * Executes yarn and runs a specified command (e.g. install / update)
     */
    public function execute()
    {
        // check command
        if ($this->command === null) {
            $this->build->setStatus(Build::STATUS_FAILED);
            $this->phpci->log('Missing required "command" parameter', LogLevel::ERROR);
            return false;
        }
        $flags = $this->flags;
        foreach ($flags as $key => $flag) {
            $flag = trim($flag);
            if ($flag !== '--no-color') {
                $flags[$key] = $flag;
            }
        }
        $flags[] = '--no-color';
        $cmd = 'cd';
        if (IS_WIN) {
            $cmd .= ' /d';
        }
        $cmd .= ' %s && %s %s %s';
        // and execute it
        return $this->phpci->executeCommand($cmd, $this->directory, $this->npm, $this->command, implode(' ', $flags));
    }

}