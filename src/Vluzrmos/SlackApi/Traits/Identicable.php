<?php

namespace Vluzrmos\SlackApi\Traits;


trait Identicable
{


	/**
	 * @param      $search
	 * @param bool $force
	 *
	 * @return array
	 */
	protected function searchIdentities($search, $force = false)
	{
		static $subjects;

		if (!$subjects || $force) {
			$subjects = $this->lists();
		}

		if (!is_array($search)) {
			$search = preg_split('/, ?/', $search);
		}

		return $this->searchSubjectsIdentityCallback($subjects, $search);
	}

	/**
	 * @param      $search
	 * @param bool $force
	 *
	 * @return string
	 */
	protected function searchIdentity($search, $force = false)
	{
		return implode(",", $this->searchIdentities($search, $force));
	}
}
