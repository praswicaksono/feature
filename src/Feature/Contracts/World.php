<?php

namespace Feature\Contracts;

/**
 * Interface World
 * @package Feature\Constracts
 */
interface World
{
    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function configValue($name, $default = null);

    /**
     * @return mixed
     */
    public function uaid();

    /**
     * @return int
     */
    public function userId();

    /**
     * @param string|int $userId
     * @return string
     */
    public function userName($userId);

    /**
     * @param int $userId
     * @param int $groupdId
     * @return bool
     */
    public function inGroup($userId, $groupdId);

    /**
     * @param int $userId
     * @return bool
     */
    public function isAdmin($userId);

    /**
     * @return bool
     */
    public function isInternalRequest();

    /**
     * @return string
     */
    public function urlFeatures();

    /**
     * @param $name
     * @param $variant
     * @param $selector
     * @return void
     */
    public function log($name, $variant, $selector);
}
