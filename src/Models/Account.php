<?php
    namespace Bearlovescode\Mastodon\Models;

    use Bearlovescode\Datamodels\DataModel;

    class Account extends DataModel
    {
        public string $id = '';
        public string $username = '';
        public string $acct = '';
        public string $url = '';
        public string $display_name = '';
        public string $note = '';
        public string $avatar = '';
        public string $avatar_static = '';
        public string $header  = '';
        public string $header_static = '';
        public bool $locked = false;
        public array $fields = [];
        public array $emojis = [];
        public bool $bot = false;
        public bool $group = false;
        public ?bool $discoverable;
        public ?bool $noindex;
        public int $followers_count = 0;
        public int $following_count = 0;

    }