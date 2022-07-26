<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleEnded extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:ended';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update schedule status to ended';

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
     * @return int
     */
    public function handle()
    {
        \Log::info("Checking schedules..");

        $date_now = Carbon::today()->format('Y-m-d');

        Schedule::where('date', '<', $date_now)
            ->update(['status' => 'ended']);

        // $schedule = Schedule::where('date', $date_now)->get();

        // foreach ($schedule as $s) {
        //     if ($s->date == $date_now && $s->status == 'active') {
        //         $s->update([
        //             'status' => 'ended',
        //         ]);
        //     }
        // }

        $this->info('Schedule status changed.');
    }
}
