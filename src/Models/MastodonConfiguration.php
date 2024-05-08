<?php
    namespace Bearlovescode\Mastodon\Models;


    use Bearlovescode\Datamodels\DataModel;
    use GuzzleHttp\Psr7\Uri;
    use Psr\Http\Message\UriInterface;


    class MastodonConfiguration extends DataModel
    {
        public UriInterface $instance;
        public UriInterface $redirect;
        public string $name;
        public string $website;
        public string $clientId;
        public string $clientSecret;
        public array $validRedirects = [];

        public string $scopes = 'read write follow push';

        public function __construct(array|object $data = null)
        {
            $this->setInstanceUrlFromData($data);
            $this->setRedirectUrlFromData($data);

            parent::__construct($data);
        }

        public function getAppName(): string
        {
            return sprintf('%s (%s)', $this->name, $this->website);
        }



        private function setInstanceUrlFromData(array|object &$data) : void
        {
            if (gettype($data) === 'array')
            {
                $this->setInstanceUrl($data['instance']);
                unset($data['instance']);
            }

            elseif (gettype($data) === 'object')
            {
                $this->setInstanceUrl($data->instance);
                unset($data->instance);
            }
        }
        private function setRedirectUrlFromData(array|object &$data) : void
        {
            if (gettype($data) === 'array')
            {
                $this->setRedirectUrl($data['redirect']);
                unset($data['redirect']);
            }

            elseif (gettype($data) === 'object')
            {
                $this->setRedirectUrl($data->redirect);
                unset($data->redirect);
            }
        }


        public function setInstanceUrl(string $url) : void
        {
            $this->instance = new Uri($url);

            if (empty($this->instance->getScheme()))
                $this->instance = $this->instance->withScheme('https');
        }

        public function setRedirectUrl(string $url) : void
        {
            $this->redirect = new Uri($url);

            if (empty($this->redirect->getScheme()))
                $this->redirect = $this->redirect->withScheme('https');

        }

    }