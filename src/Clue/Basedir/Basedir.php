<?php

namespace Clue\Basedir;

use Exception;

/**
 * XDG Base Directory Specification
 *
 * @link http://standards.freedesktop.org/basedir-spec/basedir-spec-latest.html
 * @link http://stackoverflow.com/questions/1024114/location-of-ini-config-files-in-linux-unix
 * @link https://pypi.python.org/pypi/appdirs/1.2.0
 */
class Basedir
{
    /**
     * base directory to which user specific files should be stored
     *
     * @return string
     * @throws Exception
     */
    public function getHome()
    {
        if ($this->isWindows()) {
            return $this->getEnvOrThrow('HOMEDRIVE') . $this->getEnvOrThrow('HOMEPATH');
        }

        $that = $this;

        return $this->getEnvOrCall('HOME', function() use ($that) {
            if (!function_exists('posix_getuid')) {
                throw new Exception();
            }

            $data = posix_getpwuid(posix_getuid());
            return $that->dir($data['dir']);
        });
    }

    /**
     * base directory relative to which user specific data files should be stored
     *
     * @return string
     */
    public function getDataHome()
    {
        if ($this->isWindows()) {
            return $this->getEnvOrThrow('APPDATA');
        }

        return $this->getEnvOrExpand('XDG_DATA_HOME', '.local/share/');
    }

    /**
     * base directory relative to which user specific configuration files should be stored
     *
     * @return string
     */
    public function getConfigHome()
    {
        if ($this->isWindows()) {
            return $this->getEnvOrThrow('APPDATA');
        }

        return $this->getEnvOrExpand('XDG_CONFIG_HOME', '.config/');
    }

    /**
     * base directory relative to which user specific non-essential data files should be stored
     *
     * @return string
     */
    public function getCacheHome()
    {
        if ($this->isWindows()) {
            return $this->getEnvOrThrow('TEMP');
        }

        return $this->getEnvOrExpand('XDG_CACHE_HOME', '.cache/');
    }

    /**
     * base directory relative to which user-specific non-essential runtime files and other file objects (such as sockets, named pipes, ...) should be stored
     *
     * @return string
     */
    public function getRuntimeDir()
    {
        $this->assertNotWindows();

        return $this->getEnvOrThrow('XDG_RUNTIME_DIR');
    }

    /**
     * preference-ordered set of base directories to search for data files in addition to the $XDG_DATA_HOME base directory
     *
     * @return string[]
     */
    public function getDataDirs()
    {
        $this->assertNotWindows();

        return $this->splitDirs($this->getEnvOrDefault('XDG_DATA_DIRS', '/usr/local/share/:/usr/share/'));
    }

    /**
     * defines the preference-ordered set of base directories to search for configuration files in addition to the $XDG_CONFIG_HOME base directory.
     *
     * @return string[]
     */
    public function getConfigDirs()
    {
        $this->assertNotWindows();

        return $this->splitDirs($this->getEnvOrDefault('XDG_CONFIG_DIRS', '/etc/xdg/'));
    }

    protected function getEnvOrNull($name)
    {
        $value = getenv($name);

        // either no or empty value
        if ($value === false || $value === '') {
            return null;
        }

        return $value;
    }

    protected function getEnvOrCall($name, $callback)
    {
        $value = $this->getEnvOrNull($name);

        if ($value === null) {
            $value = $callback($name);
        }

        return $this->dir($value);
    }

    protected function getEnvOrThrow($name)
    {
        return $this->getEnvOrNull($name);
    }


    protected function getEnvOrDefault($name, $default)
    {
        $value = $this->getEnvOrNull($name);
        if ($value === null) {
            $value = $default;
        }

        return $value;
    }

    protected function getEnvOrExpand($name, $default)
    {
        $that = $this;

        return $this->getEnvOrCall($name, function () use ($that, $default) {
            return $that->getHome() . $default;
        });
    }

    protected function splitDirs($paths)
    {
        $ret = array();
        foreach (explode(DIRECTORY_SEPARATOR, $paths) as $path) {
            $ret[] = $this->dir($path);
        }

        return $ret;
    }

    public function dir($path)
    {
        return rtrim($path, '/') . '/';
    }

    private function isWindows()
    {
        return defined('PHP_WINDOWS_VERSION_BUILD');
    }

    private function assertNotWindows()
    {
        if ($this->isWindows()) {
            throw new \Exception();
        }
    }
}
