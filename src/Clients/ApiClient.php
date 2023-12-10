<?php
    namespace Bearlovescode\Mastodon\Clients;

    use Bearlovescode\Mastodon\Exceptions\ApiNotFoundException;
    use Bearlovescode\Mastodon\Exceptions\ApiUnauthorizedException;
    use Bearlovescode\Mastodon\Models\MastodonConfiguration;
    use GuzzleHttp\Client;
    use GuzzleHttp\Psr7\Request;

    class ApiClient
    {
        public function __construct(
            private readonly MastodonConfiguration $config
        )
        {
            $clientOptions = [];
            $this->client = new Client($clientOptions);
        }

//        public function authorize()
//        {
//
//        }
//
//        public function authenticate()
//        {
//
//        }

        /**
         * @return void
         * @throws \GuzzleHttp\Exception\GuzzleException
         */
        public function authorize()
        {

            $req = new Request('get', '/oauth/authorize',
            [
                'query' => [
                    'client_id' => $this->config->clientId,
                    'scope' => $this->config->scopes,
                    'redirect_uri' => $this->config->redirect,
                    'response_type' => 'code'
                ]
            ]);

            $res = $this->client->send($req);

            if ($res->getStatusCode() !== 200)
                $this->handleStatusError($res->getStatusCode());


        }
        public function token(string $authCode)
        {
            $req = new Request('/oauth/token', null, [
                'form' => [
                    'client_id' => $this->config->clientId,
                    'client_secret' => $this->config->clientSecret,
                    'redirect_uri' => $this->config->redirect,
                    'grant_type' => 'authorization_code',
                    'code' => $authCode,
                    'scope' => $this->config->scopes
                ]
            ]);
        }

        public function handleStatusError(string $status = '')
        {
            match ($status) {
                '401' => throw new ApiUnauthorizedException(),
                '404' => throw new ApiNotFoundException()
            };
        }
    }