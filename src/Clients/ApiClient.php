<?php
    namespace Bearlovescode\Mastodon\Clients;

    use Bearlovescode\Mastodon\Models\MastodonConfiguration;
    use GuzzleHttp\Client;

    class ApiClient
    {
        public function __construct(MastodonConfiguration $mConfig)
        {
            $clientOptions = [];
            $this->client = new Client($clientOptions);
        }

        public function authorize()
        {

        }

        public function authenticate()
        {

        }
    }