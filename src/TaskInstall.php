<?php
namespace mawdoo3\test;

use Illuminate\Console\Command;

class TaskInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'initial install of Custom Search';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        exec("php artisan vendor:publish --provider='mawdoo3\laravelTask\TaskServiceProvider'");
        $this->line("<info>Publishing:</info> Publishing Configration Done");
        exec("php artisan migrate --path=/database/migrations/TaskInstall");
        $this->line("<info>Migrating:</info> Migrating to DB Done");
        $this->line(PHP_EOL."<info>All Done !!</info>");
    }
}
