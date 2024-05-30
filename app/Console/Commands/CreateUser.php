<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user {login} {password} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $login = $this->argument('login');
        $password = $this->argument('password');
        $name = $this->argument('name');

        $user = new User();
        $user->email = $login;
        $user->password = Hash::make($password);
        $user->name = $name;
        $user->save();

        $this->info('User created successfully');
    }
}
