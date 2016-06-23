<?php

namespace Feature;

use Feature\Contracts\User;
use Feature\Contracts\World;

/**
 * Class Feature
 * @package Feature
 */
final class Feature
{
    /**
     * @var self
     */
    private static $instance;

    /**
     * @var World
     */
    private $world;

    /**
     * @var array
     */
    private $stanza;

    /**
     * @var array
     */
    private static $config = [];

    /**
     * @param World $world
     * @param array $stanza
     */
    private function __construct(World $world, array $stanza)
    {
        $this->world = $world;
        $this->stanza = $stanza;
    }

    /**
     * @param World $world
     * @param array $stanza
     * @return Feature
     */
    public static function create(World $world, array $stanza)
    {
        if (static::$instance) {
            return static::$instance;
        }

        static::$instance = new static($world, $stanza);

        return static::$instance;
    }

    /**
     * @param $feature
     * @return bool
     */
    public static function isEnabled($feature)
    {
        return static::createConfig($feature)->isEnabled();
    }

    /**
     * @param $feature
     * @param User $user
     * @return bool
     */
    public static function isEnabledFor($feature, User $user)
    {
        return static::createConfig($feature)->isEnabledFor($user);
    }

    /**
     * @param $feature
     * @param $bucketId
     * @return bool
     */
    public static function isEnabledBucketingBy($feature, $bucketId)
    {
        return static::createConfig($feature)->isEnabledBucketingBy($bucketId);
    }

    /**
     * @param $feature
     * @return string
     */
    public static function variant($feature)
    {
        return static::createConfig($feature)->variant();
    }

    /**
     * @param $feature
     * @param User $user
     * @return string
     */
    public static function variantFor($feature, User $user)
    {
        return static::createConfig($feature)->variantFor($user);
    }

    /**
     * @param $feature
     * @param $bucketId
     * @return string
     */
    public static function variantBucketingBy($feature, $bucketId)
    {
        return static::createConfig($feature)->variantBucketingBy($bucketId);
    }

    /**
     * @param $feature
     * @return mixed|null
     */
    public static function description($feature)
    {
        return static::createConfig($feature)->description();
    }

    /**
     * clear config
     */
    public static function clear()
    {
        static::$config = [];
        static::$instance = null;
    }

    /**
     * @param $feature
     * @return Config
     */
    private static function createConfig($feature)
    {
        if (array_key_exists($feature, static::$config)) {
            return static::$config[$feature];
        }

	$stanza_config = isset(static::$instance->stanza[$feature]) ? static::$instance->stanza[$feature] : 'off';
        
        static::$config[$feature] = new Config(
            $feature,
            $stanza_config,
            static::$instance->world
        );

        return static::$config[$feature];
    }
}
