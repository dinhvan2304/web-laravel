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
        $alerts = Alert::all();
        $now = Carbon::now()->format('Y-m-d\TH:i:s');
        $latestSend = setting("latest_send_notification");
        
        foreach($alerts as $aAlert){
            $keywords = AlertKeyword::where('alert_id', $aAlert->id)->select("keyword")->get();
            $keywords = Arr::pluck($keywords, 'keyword');
            $keyword_str = '"'.implode("\" or \"", $keywords).'"';
            $keyword_str = "topic:(".$keyword_str.") AND publish_date:[$latestSend TO $now]";


            $scopes = AlertScope::where('alert_id', $aAlert->id)->select("scope")->get();
            $scopes = Arr::pluck($scopes, 'scope');
            $scope_str = implode(",", $scopes);

			$client = new \GuzzleHttp\Client();
			$response = $client->get("http://127.0.0.1:9200/$scope_str/_search?q=$keyword_str&sort=publish_date:desc&size=100");
            $result = json_decode($response->getBody());
            // dd($result->hits->total);
            if(isset($result->hits) && $result->hits->total > 0 && isset($aAlert->user->email)){
                $emails = [$aAlert->user->email];
                Log::error($emails);
                Mail::send('emails.news', ['user' => $aAlert->user, 'hits' => $result->hits->hits], function($message) use ($emails){    
                    $message->to($emails)->subject('Email News notification!');    
                });
            }
        }
        setting(['latest_send_notification' => Carbon::now()->format('Y-m-d\TH:i:s')])->save();
        
        // event(new RateEvent(json_encode($data)));
    }
}
