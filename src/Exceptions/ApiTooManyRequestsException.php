<?php
    namespace Bearlovescode\Mastodon\Exceptions;

    use Psr\Http\Message\ResponseInterface;
    use \Throwable;

    class ApiTooManyRequestsException extends \Exception
    {
        private ResponseInterface $response;
        public array $rateLimit = [
            'limit' => null,
            'remaining' => null,
            'reset' => null
        ];

        public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, ResponseInterface $response = null)
        {
            $this->response = $response;
            parent::__construct($message, $code, $previous);
            $this->loadRateLimitHeaders();
        }

        private function loadRateLimitHeaders(): void
        {
            $limitKeys = [
                'X-RateLimit-Limit',
                'X-RateLimit-Remaining',
                'X-RateLimit-Reset',
            ];
            $headers = $this->response->getHeaders();

            foreach ($limitKeys as $key) {
                if (isset($headers[$key])) {
                    $this->rateLimit[$key] = $headers[$key];
                }
            }
        }

    }