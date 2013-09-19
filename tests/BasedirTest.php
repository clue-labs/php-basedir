<?php

use Clue\Basedir\Basedir;

class BasedirTest extends TestCase
{
    private $basedir;

    public function setUp()
    {
        $this->basedir = new Basedir();
    }

    public function testTypes()
    {
        $this->assertString($this->basedir->getHome());
        $this->assertString($this->basedir->getCacheHome());
        $this->assertString($this->basedir->getConfigHome());
        $this->assertString($this->basedir->getDataHome());
        $this->assertString($this->basedir->getRuntimeDir());

        $this->assertArray($this->basedir->getConfigDirs());
        $this->assertArray($this->basedir->getDataDirs());
    }
}
