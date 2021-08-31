<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $podcast;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->podcast = [
            'a' => 'b',
            'b' => [
                'a' => 'b',
                'b' => [
                    'a' => 'b',
                    'b' => [
                        'a' => 'b',
                        'b' => [
                            'a' => 'b',
                            'b' => [
                                'a' => 'b',
                                'b' => [
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // php artisan queue:work
        var_dump('Event processing job' . 's');
    }
}
