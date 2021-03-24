<?php

namespace App\Console\Commands;

use App\User;
use Artisan;
use Illuminate\Console\Command;

class StartBase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:base';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrates the DB, and creates User Denis';

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
        $exit = Artisan::call('migrate');

        logger($exit);

        $user = factory(User::class)->create([
            'name' => 'Denis',
            'email' => 'denis@gmail.com',
            'password' => '1234'
        ]);

        logger($user);
    }
}
