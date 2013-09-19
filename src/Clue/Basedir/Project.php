<?php

namespace Clue\Basedir;

use Clue\Basedir\Basedir;

class Project
{
    private $name;
    private $basedir;

    public function __construct($name, Basedir $basedir = null)
    {
        if ($basedir === null) {
            $basedir = new Basedir();
        }

        $this->name = $name;
        $this->basedir = $basedir;
    }

    public function getFirstReadable(array $paths)
    {
        foreach ($paths as $path) {
            if (is_file($path) && is_readable($path)) {
                return $path;
            }
        }

        return null;
    }

    public function getDataPaths($name)
    {
        return $this->getPaths(array_merge(array($this->basedir->getDataHome()), $this->basedir->getDataDirs()), $name);
    }

    public function getConfigPaths($name)
    {
        return $this->getPaths(array_merge(array($this->basedir->getConfigHome()), $this->basedir->getConfigDirs()), $name);
    }

    protected function getPaths(array $bases, $local)
    {
        foreach ($bases as &$base) {
            $base = $this->getPath($base, $local);
        }

        return $bases;
    }

    protected function getPath($base, $local)
    {
        return $base. str_replace('/', '-', $this->name) . '/' . $local;
    }
}
