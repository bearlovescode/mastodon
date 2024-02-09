<?php
    namespace Bearlovescode\Mastodon\Services;

    use Bearlovescode\Mastodon\Clients\ApiClient;
    use Bearlovescode\Mastodon\Models\MastodonConfiguration;

    abstract class ApiService
    {
        protected ApiClient $client;

        public function __construct(
            protected readonly MastodonConfiguration $config
        )
        {
            $this->configureClient();
        }

        private function configureClient() : void
        {
            if (empty($this->client))
            {
                $this->client = new ApiClient($this->config);
            }
        }
    }