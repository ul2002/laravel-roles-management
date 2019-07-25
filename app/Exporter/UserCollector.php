<?php

namespace App\Exporter; 

use Prometheus\Gauge;

class UserCollector implements CollectorInterface
{
    /**
     * @var Gauge
     */
    protected $usersRegisteredGauge;
    /**
     * Return the name of the collector.
     *
     * @return string
     */
    public function getName()
    {
        return 'users';
    }
    /**
     * Register all metrics associated with the collector.
     *
     * The metrics needs to be registered on the exporter object.
     * eg:
     * ```php
     * $exporter->registerCounter('search_requests_total', 'The total number of search requests.');
     * ```
     *
     * @param PrometheusExporter $exporter
     */
    public function registerMetrics(PrometheusExporter $exporter)
    {
        $this->usersRegisteredGauge = $exporter->registerGauge(
            'users_registered_total',
            'The total number of registered users.',
            ['role']
        );
    }
    /**
     * Collect metrics data, if need be, before exporting.
     *
     * As an example, this may be used to perform time consuming database queries and set the value of a counter
     * or gauge.
     */
    public function collect()
    {
        // retrieve the total number of admin users registered
        // eg: $totalUsers = Users::where('role', 'admin')->count();
        $this->usersRegisteredGauge->set(36, ['admin']);
        // retrieve the total number of regular member registered
        // eg: $totalUsers = Users::where('role', 'member')->count();
        $this->usersRegisteredGauge->set(192, ['member']);
    }
}
