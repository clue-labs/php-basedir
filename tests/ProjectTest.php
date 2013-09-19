<?php

use Clue\Basedir\Project;

class ProjectTest extends TestCase
{
    private $project;

    public function setUp()
    {
        $this->project = new Project('clue/basedir');
    }

    public function testTypes()
    {
        $this->assertArray($this->project->getConfigPaths('main'));
        $this->assertArray($this->project->getDataPaths('main'));
    }
}
