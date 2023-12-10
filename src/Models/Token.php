<?php
    namespace Bearlovescode\Mastodon\Models;

    use Bearlovescode\Datamodels\DataModel;

    class Token extends DataModel
    {
        public string $value;
        public string $type;
        public string $scope;
        public int $createdAt;

    }