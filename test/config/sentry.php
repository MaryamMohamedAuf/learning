<?php

/**
 * Sentry Laravel SDK configuration file.
 *
 * @see https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/
 */
return [

    // @see https://docs.sentry.io/product/sentry-basics/dsn-explainer/
    'dsn' => env('SENTRY_LARAVEL_DSN', env('SENTRY_DSN')),

    // @see https://spotlightjs.com/
    // 'spotlight' => env('SENTRY_SPOTLIGHT', false),

    // @see: https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/#logger
    // 'logger' => Sentry\Logger\DebugFileLogger::class, // By default this will log to `storage_path('logs/sentry.log')`

    // The release version of your application
    // Example with dynamic git hash: trim(exec('git --git-dir ' . base_path('.git') . ' log --pretty="%h" -n1 HEAD'))
    'release' => env('SENTRY_RELEASE'),

    // When left empty or `null` the Laravel environment will be used (usually discovered from `APP_ENV` in your `.env`)
    'environment' => env('SENTRY_ENVIRONMENT'),

    // @see: https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/#sample_rate
    'sample_rate' => env('SENTRY_SAMPLE_RATE') === null ? 1.0 : (float) env('SENTRY_SAMPLE_RATE'),

    // @see: https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/#traces_sample_rate
    'traces_sample_rate' => env('SENTRY_TRACES_SAMPLE_RATE') === null ? null : (float) env('SENTRY_TRACES_SAMPLE_RATE'),

    // @see: https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/#profiles-sample-rate
    'profiles_sample_rate' => env('SENTRY_PROFILES_SAMPLE_RATE') === null ? null : (float) env('SENTRY_PROFILES_SAMPLE_RATE'),

    // @see: https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/#enable_logs
    'enable_logs' => env('SENTRY_ENABLE_LOGS', true),

    // @see: https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/#send_default_pii
    'send_default_pii' => env('SENTRY_SEND_DEFAULT_PII', false),

    // Drop noisy, repeated issues after a threshold in a rolling TTL window.
    // Controlled via env:
    // - SENTRY_THROTTLE_ENABLED=true
    // - SENTRY_THROTTLE_REPEAT_THRESHOLD=2
    // - SENTRY_THROTTLE_TTL_SEC=300
    'before_send' => static function (\Sentry\Event $event, ?\Sentry\EventHint $hint): ?\Sentry\Event {
        if (! env('SENTRY_THROTTLE_ENABLED', false)) {
            return $event;
        }

        try {
            $ttl_seconds = (int) env('SENTRY_THROTTLE_TTL_SEC', 300);
            $repeat_threshold = (int) env('SENTRY_THROTTLE_REPEAT_THRESHOLD', 50);

            // Build a stable signature per "issue"
            $signature_parts = [];

            if ($hint !== null && property_exists($hint, 'exception') && $hint->exception instanceof \Throwable) {
                /** @var \Throwable $ex */
                $ex = $hint->exception;
                $signature_parts[] = get_class($ex);
                $signature_parts[] = (string) $ex->getCode();
                $signature_parts[] = (string) $ex->getMessage();
                $signature_parts[] = basename((string) $ex->getFile()) . ':' . (string) $ex->getLine();
               $trace = $ex->getTraceAsString();
//                $signature_parts[] = substr($trace, 0, 2000);
               // $trace = $ex->getTrace();
                $signature_parts[] = $trace;

            } else {
                // Fall back to message + logger + culprit route if present
                $signature_parts[] = (string) ($event->getMessage() ?? '');
                $signature_parts[] = (string) ($event->getLogger() ?? '');
                $request = request();
                if ($request) {
                    $signature_parts[] = $request->method() . ' ' . $request->path();
                }
            }
 dd($signature_parts);
            $issue_hash = hash('sha256', implode('|', $signature_parts));
            $cache_key = 'sentry:throttle:' . $issue_hash;

            // Ensure the key exists with TTL, then increment atomically
            cache()->add($cache_key, 0, $ttl_seconds);
            $current_count = cache()->increment($cache_key);

            if ($current_count > $repeat_threshold) {
                // Returning null drops the event
                return null;
            }

            return $event;
        } catch (\Throwable $t) {
            // Fail-open: don't block reporting if throttling logic errors
            return $event;
        }
    },

    // @see: https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/#ignore_exceptions
    // 'ignore_exceptions' => [],

    // @see: https://docs.sentry.io/platforms/php/guides/laravel/configuration/options/#ignore_transactions
    'ignore_transactions' => [
        // Ignore Laravel's default health URL
        '/up',
    ],

    // Breadcrumb specific configuration
    'breadcrumbs' => [
        // Capture Laravel logs as breadcrumbs
        'logs' => env('SENTRY_BREADCRUMBS_LOGS_ENABLED', true),

        // Capture Laravel cache events (hits, writes etc.) as breadcrumbs
        'cache' => env('SENTRY_BREADCRUMBS_CACHE_ENABLED', true),

        // Capture Livewire components like routes as breadcrumbs
        'livewire' => env('SENTRY_BREADCRUMBS_LIVEWIRE_ENABLED', true),

        // Capture SQL queries as breadcrumbs
        'sql_queries' => env('SENTRY_BREADCRUMBS_SQL_QUERIES_ENABLED', true),

        // Capture SQL query bindings (parameters) in SQL query breadcrumbs
        'sql_bindings' => env('SENTRY_BREADCRUMBS_SQL_BINDINGS_ENABLED', false),

        // Capture queue job information as breadcrumbs
        'queue_info' => env('SENTRY_BREADCRUMBS_QUEUE_INFO_ENABLED', true),

        // Capture command information as breadcrumbs
        'command_info' => env('SENTRY_BREADCRUMBS_COMMAND_JOBS_ENABLED', true),

        // Capture HTTP client request information as breadcrumbs
        'http_client_requests' => env('SENTRY_BREADCRUMBS_HTTP_CLIENT_REQUESTS_ENABLED', true),

        // Capture send notifications as breadcrumbs
        'notifications' => env('SENTRY_BREADCRUMBS_NOTIFICATIONS_ENABLED', true),
    ],

    // Performance monitoring specific configuration
    'tracing' => [
        // Trace queue jobs as their own transactions (this enables tracing for queue jobs)
        'queue_job_transactions' => env('SENTRY_TRACE_QUEUE_ENABLED', true),

        // Capture queue jobs as spans when executed on the sync driver
        'queue_jobs' => env('SENTRY_TRACE_QUEUE_JOBS_ENABLED', true),

        // Capture SQL queries as spans
        'sql_queries' => env('SENTRY_TRACE_SQL_QUERIES_ENABLED', true),

        // Capture SQL query bindings (parameters) in SQL query spans
        'sql_bindings' => env('SENTRY_TRACE_SQL_BINDINGS_ENABLED', false),

        // Capture where the SQL query originated from on the SQL query spans
        'sql_origin' => env('SENTRY_TRACE_SQL_ORIGIN_ENABLED', true),

        // Define a threshold in milliseconds for SQL queries to resolve their origin
        'sql_origin_threshold_ms' => env('SENTRY_TRACE_SQL_ORIGIN_THRESHOLD_MS', 100),

        // Capture views rendered as spans
        'views' => env('SENTRY_TRACE_VIEWS_ENABLED', true),

        // Capture Livewire components as spans
        'livewire' => env('SENTRY_TRACE_LIVEWIRE_ENABLED', true),

        // Capture HTTP client requests as spans
        'http_client_requests' => env('SENTRY_TRACE_HTTP_CLIENT_REQUESTS_ENABLED', true),

        // Capture Laravel cache events (hits, writes etc.) as spans
        'cache' => env('SENTRY_TRACE_CACHE_ENABLED', true),

        // Capture Redis operations as spans (this enables Redis events in Laravel)
        'redis_commands' => env('SENTRY_TRACE_REDIS_COMMANDS', false),

        // Capture where the Redis command originated from on the Redis command spans
        'redis_origin' => env('SENTRY_TRACE_REDIS_ORIGIN_ENABLED', true),

        // Capture send notifications as spans
        'notifications' => env('SENTRY_TRACE_NOTIFICATIONS_ENABLED', true),

        // Enable tracing for requests without a matching route (404's)
        'missing_routes' => env('SENTRY_TRACE_MISSING_ROUTES_ENABLED', false),

        // Configures if the performance trace should continue after the response has been sent to the user until the application terminates
        // This is required to capture any spans that are created after the response has been sent like queue jobs dispatched using `dispatch(...)->afterResponse()` for example
        'continue_after_response' => env('SENTRY_TRACE_CONTINUE_AFTER_RESPONSE', true),

        // Enable the tracing integrations supplied by Sentry (recommended)
        'default_integrations' => env('SENTRY_TRACE_DEFAULT_INTEGRATIONS_ENABLED', true),
    ],

];
