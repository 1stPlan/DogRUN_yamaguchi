<?php

namespace App\Console\Commands;

use App\Mail\Event\RemindEventStartForParticipant;
use App\Models\Event\Event;
use App\Models\Event\EventParticipant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEventStartRemindMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     *             引数はない場合は現在の時間から計算
     */
    // 例 php artisan send:eventStartRemind 20241204 15:30:00
    protected $signature = 'send:eventStartRemind {date?} {time?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '開催1時間前に参加者にメールを送信する';

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

        if ($this->argument('date') && $this->argument('time')) {
            $date = Carbon::createFromFormat('Ymd H:i:s', $this->argument('date').$this->argument('time'));
        } else {
            $hour = carbon::now()->hour;
            $minute = carbon::now()->minute;
            $second = 0;
            $date = Carbon::createFromTime($hour, $minute, $second);
        }

        // // Eventテーブルから (指定の日時 + 50分01秒) ~ (指定の日時 + 60分00秒)に開催されるイベントを取得
        $fiftyMinutesLater = $date->copy()->addMinutes(50)->addSecond(1);
        $sixtyMinutesLater = $date->copy()->addMinutes(60);

        $events = Event::startedBetween($fiftyMinutesLater, $sixtyMinutesLater)->with('eventSearches')->get();
        // ここが大事なところ

        if (count($events)) {
            foreach ($events as $event) {

                $eventParticipants = EventParticipant::eventId($event->id)->get();

                if (count($eventParticipants)) {

                    // 参加者がいる場合、参加者にメールを送る
                    foreach ($eventParticipants as $eventParticipant) {

                        Mail::to(User::id($eventParticipant->user_id)->first()->email)->send(new RemindEventStartForParticipant($event, User::id($eventParticipant->user_id)->first()));
                    }
                }
            }
        }

    }
}
