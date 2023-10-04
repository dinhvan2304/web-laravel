<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Exception;
use App\Models\Alert;
use App\Models\AlertKeyword;
use App\Models\AlertScope;
use GuzzleHttp\Client;
use Log;
use Arr;
use Mail;
use Carbon\Carbon;

// use App\Events\Rate as RateEvent;

class EmailNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emailnews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email news';

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
        Log::error("------ BEGIN SEND NOTIFICATION------");
        $now = Carbon::now()->format('Ymd');
        
        $results = DB::select(DB::raw("
            select tt.so_tbmt, tt.ten_goi_thau, tt.ben_moi_thau
            from `thong_tin_goi_thau` tt
            where tt.send_mail_id is null and tt.thoi_diem_dang_tai >= $now and tt.score_service >= 0.4
        "));
        $users = DB::select(DB::raw("
            select distinct u.* from users u
            join alerts a on a.user_id = u.id
        "));
        // dd($results);

        if(isset($results) && count($results) > 0 && count($users) > 0){
            foreach ($users as $aUser) {
                $emails = [$aUser->email];
                Log::error($emails);
                Mail::send('emails.news', ['user' => $aUser, 'hits' => $results], function($message) use ($emails){    
                    $message->to($emails)->subject('Thông tin gói thầu mới!');    
                });
            }
            DB::update("update thong_tin_goi_thau set send_mail_id = 1 where send_mail_id is null and thoi_diem_dang_tai >= $now and score_service >= 0.4");
        }
        Log::error("------ END SEND NOTIFICATION------");
    }
}
