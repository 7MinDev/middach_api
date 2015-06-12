<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    use DatabaseMigrations;

    /**
     * the base url to use when testing
     * @var string
     */
    protected $baseUrl = 'http://middach.dev:8000';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function setUp()
    {
        parent::setUp();
        $this->runDatabaseMigrations();
        Mail::pretend(true);
    }

}
