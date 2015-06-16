<?php

namespace Vluzrmos\SlackApi\Methods;

use Vluzrmos\SlackApi\Contracts\SlackGroup;
use Vluzrmos\SlackApi\Traits\Identicable;

class Group extends Channel implements SlackGroup
{
	//use Identicable;

    protected $methodsGroup = "groups.";

    /**
     * This method opens a private group.
     *
     * @param string $channel Group to open.
     *
     * @return array
     */
    public function open($channel)
    {
        return $this->method('open', compact('channel'));
    }

    /**
     * This method closes a private group.
     *
     * @param string $channel Group to close
     *
     * @return array
     */
    public function close($channel)
    {
        return $this->method('close', compact('channel'));
    }

    /**
     * This method takes an existing private group and performs the following steps:
     *
     * - Renames the existing group (from "example" to "example-archived").
     * - Archives the existing group.
     * - Creates a new group with the name of the existing group.
     * - Adds all members of the existing group to the new group.
     *
     * This is useful when inviting a new member to an existing group while hiding all previous
     * chat history from them. In this scenario you can call groups.createChild followed by groups.invite.
     *
     * The new group will have a special parent_group property pointing to the original archived group.
     * This will only be returned for members of both groups, so will not be visible to any newly invited members.
     *
     * @see https://api.slack.com/methods/groups.createChild
     *
     * @param $channel
     *
     * @return array
     */
    public function createChild($channel)
    {
        return $this->method('createChild', compact('channel'));
    }

	/**
	 * Get a groups id
	 * @param string|array $search
	 * @param bool $force
	 *
	 * @return array
	 */
	public function getGroupsIdentities($search, $force = false)
	{
		return $this->getChannelsIdentities($search, $force);
	}

	/**
	 * Get a groups id comma separated
	 *
	 * @param string|array $search
	 * @param bool $force
	 *
	 * @return string
	 */
	public function getGroupIdentity($search, $force = false)
	{
		return $this->getChannelIdentity($search, $force);
	}
}
