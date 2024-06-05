<?php
    namespace Bearlovescode\Mastodon\Clients;

    use Bearlovescode\Mastodon\Exceptions\ApiBadRequestException;
    use Bearlovescode\Mastodon\Exceptions\ApiForbiddenException;
    use Bearlovescode\Mastodon\Exceptions\ApiNotFoundException;
    use Bearlovescode\Mastodon\Exceptions\ApiServerErrorException;
    use Bearlovescode\Mastodon\Exceptions\ApiTooManyRequestsException;
    use Bearlovescode\Mastodon\Exceptions\ApiUnauthorizedException;
    use Bearlovescode\Mastodon\Models\MastodonConfiguration;
    use Bearlovescode\Mastodon\Models\Token;
    use GuzzleHttp\Client;
    use GuzzleHttp\Psr7\Request;
    use GuzzleHttp\Psr7\Response;
    use GuzzleHttp\Psr7\Rfc7230;
    use Psr\Http\Message\ResponseInterface;

    class ApiClient
    {
        public function __construct(
            protected readonly MastodonConfiguration $config
        )
        {
            $clientOptions = [
                'base_uri' => $this->config->instance
            ];

            $this->client = new Client($clientOptions);
        }

        public function handle(Request $req, array $options = [])
        {
            $res = $this->client->send($req, $options);

            if ($res->getStatusCode() !== 200)
                $this->handleStatusError($res->getStatusCode());

            $data = $res->getBody()->getContents();
            return json_decode($data);
        }


        /**
         * @return void
         * @throws \GuzzleHttp\Exception\GuzzleException
         */
        public function authorize() : Token
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
                $this->handleStatusError($res);


            $data = $this->parseBodyContent($res);
            return $data->code;


        }
        public function token(string $authCode)
        {
            $req = new Request('post', '/oauth/token', [
                'form_params' => [
                    'client_id' => $this->config->clientId,
                    'client_secret' => $this->config->clientSecret,
                    'redirect_uri' => (string) $this->config->redirect,
                    'grant_type' => 'authorization_code',
                    'code' => $authCode,
                    'scope' => $this->config->scopes
                ]
            ]);

            $res = $this->client->send($req);

            if ($res->getStatusCode() !== 200)
                $this->handleStatusError($res->getStatusCode());

            $data = $res->getBody()->getContents();
            return json_decode($data);
        }

        public function verify()
        {
            $req = new Request('');
        }

        public function handleStatusError(ResponseInterface $res)
        {
            match ($res->getStatusCode()) {
                '400' => throw new ApiBadRequestException(),
                '401' => throw new ApiUnauthorizedException(),
                '403' => throw new ApiForbiddenException(),
                '404' => throw new ApiNotFoundException(),
                '429' => throw new ApiTooManyRequestsException(response: $res),
                '500' => throw new ApiServerErrorException(),
                default => throw new \Exception('Unexpected match value')
            };
        }

        public function parseBodyContent(Response $res)
        {
            return json_decode($res->getBody()->getContents());
        }
    }