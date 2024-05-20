<?php

namespace App\Controllers;

use App\Models\JobModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $session;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
        $this->initialize();
    }

    protected function initialize()
    {
        $this->processPendingJobs();
    }

    protected function processPendingJobs()
    {
        log_message('debug', 'Processing pending jobs...');

        $jobModel = new JobModel();
        $now = date('Y-m-d H:i:s');
        $jobs = $jobModel->where('run_at <=', $now)
            ->where('status', 'pending')
            ->findAll();

        log_message('debug', 'Found ' . count($jobs) . ' pending jobs.');

        foreach ($jobs as $job) {
            log_message('debug', 'Processing job ID: ' . $job['id']);
            $payload = json_decode($job['payload'], true);
            $jobClass = $job['type'];
            $jobInstance = new $jobClass();

            try {
                $jobInstance->run($payload);
                $jobModel->update($job['id'], ['status' => 'completed']);
                log_message('debug', 'Job ID ' . $job['id'] . ' completed.');
            } catch (\Exception $e) {
                $jobModel->update($job['id'], ['status' => 'failed']);
                log_message('error', 'Job ID ' . $job['id'] . ' failed: ' . $e->getMessage());
            }
        }
    }
}
