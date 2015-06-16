<?php

namespace Vluzrmos\SlackApi\Methods;

use Vluzrmos\SlackApi\Contracts\SlackUser;
use Vluzrmos\SlackApi\Traits\Identicable;

class User extends SlackMethod implements SlackUser
{
	use Identicable;

    protected $methodsGroup = "users.";

    /**
     * This method lets you find out information about a user's presence.
     * Consult the presence documentation for more details.
     *
     * @param string $user User ID to get presence info on. Defaults to the authed user.
     *
     * @return array
     */
    public function getPresence($user)
    {
        return $this->method('getPresence', compact('user'));
    }

    /**
     * This method returns information about a team member.
     *
     * @param string $userId User ID to get info on
     *
     * @return array
     */
    public function info($userId)
    {
        return $this->method('info', ['user' => $userId]);
    }

    /**
     * This method returns a list of all users in the team. This includes deleted/deactivated users.
     *
     * @return array
     */
    public function lists()
    {
        return $this->method('list');
    }

    /**
     * Alias to lists
     *
     * @return array
     */
    public function all()
    {
        return $this->lists();
    }

    /**
     * This method lets the slack messaging server know that the authenticated user is currently active.
     * Consult the presence documentation for more details.
     *
     * @return array
     */
    public function setActive()
    {
        return $this->method('setActive');
    }

    /**
     * This method lets you set the calling user's manual presence.
     * Consult the presence documentation for more details.
     *
     * @param $presence
     *
     * @return array
     */
    public function setPresence($presence)
    {
        return $this->method('setPresence', compact('presence'));
    }

    /**
     * Get an array of users id's by nicks, username, email
     *
     * @param string|array $search
     * @param bool $force force to reload the users list
     *
     * @return array
     */
    public function getUsersIdentities($search, $force = false)
    {
        return $this->searchIdentities($search, $force);
    }


	/**
	 * Returns a comma separated users ids
	 *
	 * @param string $search
	 *
	 * @param bool $force
	 *
	 * @return string
	 */
	public function getUserIdentity($search, $force = false)
	{
		$users = $this->getUsersIdentities($search, $force);

		return implode(",", $users);
	}

    /**
     * Verify if a given identity is for the user
     *
     * @param array $user
     * @param string $identity
     *
     * @return bool
     */
    protected function isUserIdentity($user, $identity)
    {
		$identity = preg_replace('/^@/', '', $identity);

        return in_array($identity,  [ $user['name'], $user['id'], $user['profile']['email'] ]);
    }

    /**
     * Check if a given identity is for the slackbot
     *
     * @param string $identity
     *
     * @return bool
     */
    protected function isSlackbotIdentity($identity)
    {
		$identity = preg_replace('/^@/', '', $identity);

        return in_array($identity, ['slackbot', 'USLACKBOT']);
    }

	/**
	 * For Identicable trait, to search members and return his id
	 * @param array $users
	 * @param array $search
	 *
	 * @return array
	 */
	protected function searchSubjectsIdentityCallback($users, $search = [])
	{
		$usersIds = [ ];

		foreach ($users['members'] as $user) {
			foreach ($search as $searching) {
				if ($this->isUserIdentity($user, $searching)) {
					$usersIds[] = $user['id'];
				} elseif ($this->isSlackbotIdentity($searching)) {
					$usersIds[] ='USLACKBOT';
				}
			}
		}

		return $usersIds;
	}

}
