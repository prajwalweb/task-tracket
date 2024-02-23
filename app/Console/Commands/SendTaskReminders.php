<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Notifications\DueTaskReminder;
use Carbon\Carbon;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-task-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send due date reminders to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::where('due_date', '<=', now()->addDays(1))->get();

        foreach ($tasks as $task) {
            $user = $task->user;
            $formatted_dt1=Carbon::parse($task->due_date);
            $daysLeft = $formatted_dt1->diffInDays(now());

            $user->notify(new DueTaskReminder($task, $daysLeft));
        }

        $this->info('Task reminders sent successfully.');
    }
}
