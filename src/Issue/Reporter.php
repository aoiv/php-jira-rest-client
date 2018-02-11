<?php

namespace JiraRestApi\Issue;

use JiraRestApi\ClassSerialize;

class Reporter implements \JsonSerializable
{
    use ClassSerialize;

    /** @var string */
    public $self;

    /** @var string */
    public $name;

    /** @var string */
    public $emailAddress;

    /** @var array|null */
    public $avatarUrls;

    /** @var string */
    public $displayName;

    /** @var string */
    public $active;

    public function jsonSerialize()
    {
        $vars = (get_object_vars($this));
        foreach ($vars as $key => $value) {
            if ($key === 'name' && !is_null($value)) {
                continue;
            } elseif (is_null($value) || $value === '') {
                unset($vars[$key]);
            }
        }
        if (empty($vars)) {
            return null;
        }

        return $vars;
    }

    /**
     * determine class has value for effective json serialize.
     *
     * @see https://github.com/lesstif/php-jira-rest-client/issues/126
     *
     * @return bool
     */
    public function isEmpty()
    {
        if (empty($this->name) && empty($this->self)) {
            return true;
        }

        return false;
    }
}
