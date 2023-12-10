<?php
    namespace Bearlovescode\Mastodon\Models;

    use League\Uri\Uri;
    use Bearlovescode\Datamodels\DataModel;


    class MastodonConfiguration extends DataModel
    {
        public Uri $instance;
        public Uri $redirect;
        public string $clientId;
        public string $clientSecret;

        public string $scopes = 'read write push follow';

        public function __construct(array|object $data = null)
        {
            $this->setInstanceUrlFromData($data);
            $this->setRedirectUrlFromData($data);

            parent::__construct($data);
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
                $this->setInstanceUrl($data['redirect']);
                unset($data['redirect']);
            }

            elseif (gettype($data) === 'object')
            {
                $this->setInstanceUrl($data->redirect);
                unset($data->redirect);
            }
        }


        public function setInstanceUrl(string $url) : void
        {
            $this->instance = Uri::new($url);
        }

        public function setRedirectUrl(string $url) : void
        {
            $this->redirect = Uri::new($url);
        }

    }