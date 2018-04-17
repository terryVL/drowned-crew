<?php

namespace tdc\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
use tdc\models\User;

class install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tde:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepare the tdc crewbuilder for use';

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
        Artisan::call('migrate');
		if(User::where('type', User::TYPES_ADMIN)->count() == 0)
		{
			$user = new User();
			$user->type = User::TYPES_ADMIN;
			$user->name = $this->ask('what is your name?');
			$user->email = $this->ask('what is your email?');
			do
			{
				$result = $user->setPassword($this->secret('What is your password'));
				if($result != null)
				{
					$this->error($result);
				}
			}while($result != null);
			$user->save();
		}
        Artisan::call('tde:import');
    }
}
