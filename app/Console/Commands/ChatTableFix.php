<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Lexx\ChatMessenger\Models\Message;
use Lexx\ChatMessenger\Models\Participant;
use Lexx\ChatMessenger\Models\Thread;
use Illuminate\Support\Facades\Schema;

class ChatTableFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:chat-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fix old chat package to new package insert data';

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
        if (Schema::hasTable('messages')) {

            $msg_thread_table = DB::table('message_threads')->get();

            if ($msg_thread_table) {
                foreach ($msg_thread_table as $thread) {
                    $this->line($thread->id);
                    $thread = Thread::create([
                        'starred' => 1
                    ]);
                    $msg_thread_participants_table = DB::table('message_thread_participants')->where('thread_id', $thread->id)->get();
                    foreach ($msg_thread_participants_table as $participant) {
                        Participant::create([
                            'thread_id' => $thread->id,
                            'user_id' => $participant->user_id,
                            'last_read' => $participant->last_read
                        ]);
                    }
                    dump($msg_thread_participants_table);
                    $msg_messages_table = DB::table('messages')->where('thread_id', $thread->id)->get();
                    foreach ($msg_messages_table as $message) {
                        Message::create([
                            'thread_id' => $thread->id,
                            'user_id' => $message->sender_id,
                            'body' => $message->body,
                            'created_at' => $message->created_at
                        ]);
                    }
                }
            }

            DB::statement('SET FOREIGN_KEY_CHECKS = 0');

            if (Schema::hasTable('message_threads')) {
                Schema::dropIfExists('message_threads');

            }
            if (Schema::hasTable('message_thread_participants')) {
                Schema::dropIfExists('message_thread_participants');
            }
            if (Schema::hasTable('messages')) {
                Schema::dropIfExists('messages');

            }


            unlink(database_path('/migrations/2016_07_27_052049_create_messages_table.php'));
            unlink(database_path('/migrations/2016_07_31_215110_create_message_threads_table.php'));
            unlink(database_path('/migrations/2016_07_31_215345_create_message_thread_participants.php'));
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }

        return $this->line("chat table imported");
    }
}
