<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\JobModel;

class ProcessJobs extends BaseCommand
{
    protected $group       = 'Scheduled';
    protected $name        = 'jobs:process';
    protected $description = 'Process pending jobs.';

    public function run(array $params)
    {
        $jobModel = new JobModel();
        $now = date('Y-m-d H:i:s');
        $jobs = $jobModel->where('run_at <=', $now)
            ->where('status', 'pending')
            ->findAll();

        foreach ($jobs as $job) {
            $payload = json_decode($job['payload'], true);
            $jobClass = $job['type'];
            $jobInstance = new $jobClass();

            try {
                $jobInstance->run($payload);
                $jobModel->update($job['id'], ['status' => 'completed']);
                CLI::write("Job {$job['id']} processed successfully.", 'green');
            } catch (\Exception $e) {
                $jobModel->update($job['id'], ['status' => 'failed']);
                CLI::write("Job {$job['id']} failed: " . $e->getMessage(), 'red');
            }
        }
    }
}
