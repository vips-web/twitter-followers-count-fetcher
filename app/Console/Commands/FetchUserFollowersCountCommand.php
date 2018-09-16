<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twitter;

class FetchUserFollowersCountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
     protected $signature = 'fetch-user-followers-count:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch user followers count';

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
        $target_users = $results = app('db')->select("SELECT * FROM target_users");

        foreach ($target_users as $u) {
            $screen_name = $u->screen_name;

            $response = Twitter::getUsers([
                'screen_name' => $screen_name,
                'format' => 'json',
            ]);

            if (!$response) {
                continue;
            }
    
            $user = json_decode($response, true);

            if (!isset($user['followers_count'])) {
                continue;
            }

            file_put_contents(
                "/home/vipsvips/www/jp_domain/data/twitter-user-${screen_name}.json",
                $response
            );

            $followers_count = $user['followers_count'];

            app('db')->insert('INSERT INTO twitter_user_profiles (screen_name, followers_count, created_at) VALUES (?, ?, ?)', [
                $screen_name,
                $followers_count,
                \Carbon\Carbon::now(),
            ]);
        }
    }
}
