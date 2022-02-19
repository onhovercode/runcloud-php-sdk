<?php

namespace OnHover\RunCloud\Actions;

use OnHover\RunCloud\Resources\Database;
use OnHover\RunCloud\Resources\DatabaseUser;


trait ManagesDatabases
{


	/**
	 * Create a new database
	 *
	 * @param  int $serverId
	 * @param  string $name
	 * @param  string $collation
	 * @return Database
	 *
	 */
	public function createDatabase(string $serverId, string $name, string $collation = '')
	{
		$data = compact('name', 'collation');
		$data = array_filter($data, 'strlen');

		$database = $this->post("servers/{$serverId}/databases", $data);
		return new Database($database, $this);
	}


	/**
	 * Get the collection of databases
	 *
	 * @param  int $serverId
	 * @param  string $search
	 * @return Database[]
	 *
	 */
	public function databases(int $serverId, string $search = '')
	{
		$query = ['search' => $search];
		$query = array_filter($query, 'strlen');

		$response = $this->getAllData("servers/{$serverId}/databases", $query);
		return $this->transformCollection($response, Database::class);
	}


	/**
	 * Get a database
	 *
	 * @param  int $serverId
	 * @param  int $databaseId
	 * @return Database
	 *
	 */
	public function database(int $serverId, int $databaseId)
	{
		$db = $this->get("servers/{$serverId}/databases/{$databaseId}");
		return new Database($db, $this);
	}


	/**
	 * Delete a database
	 *
	 * @param  int $serverId
	 * @param  int $databaseId
	 * @param  bool $alsoDeleteUsers
	 * @return Database
	 *
	 */
	public function deleteDatabase(int $serverId, int $databaseId, bool $alsoDeleteUsers = false)
	{
		$data = [];

		if ($alsoDeleteUsers === true) {
			$data['deleteUser'] = true;
		}

		$db = $this->delete("servers/{$serverId}/databases/{$databaseId}", $data);
		return new Database($db, $this);
	}


	/**
	 * Create a database user
	 *
	 * @param  int $serverId
	 * @param  string $username
	 * @param  string $password
	 * @return DatabaseUser
	 *
	 */
	public function createDatabaseUser(string $serverId, string $username, string $password)
	{
		$data = compact('username', 'password');

		$dbUser = $this->post("servers/{$serverId}/databaseusers", $data);
		return new DatabaseUser($dbUser, $this);
	}


	/**
	 * Get the collection of database users.
	 * Optionally supply Database ID to show users granted access to that database.
	 * Optionally supply a search string.
	 *
	 * @param int $serverId
	 * @param int $databaseId
	 * @param string $search
	 * @return DatabaseUser[]
	 *
	 */
	public function databaseUsers(int $serverId, int $databaseId = null, string $search = '')
	{
		$query = ['search' => $search];
		$query = array_filter($query, 'strlen');

		if ($databaseId === null) {
			$response = $this->getAllData("servers/{$serverId}/databaseusers", $query);
		} else {
			$response = $this->getAllData("servers/{$serverId}/databases/{$databaseId}/grant", $query);
		}

		return $this->transformCollection($response, DatabaseUser::class);
	}


	/**
	 * Get a database user
	 *
	 * @param  int $serverId
	 * @param  int $databaseUserId
	 * @return DatabaseUser
	 *
	 */
	public function databaseUser(int $serverId, int $databaseUserId)
	{
		$dbUser = $this->get("servers/{$serverId}/databaseusers/{$databaseUserId}");
		return new DatabaseUser($dbUser, $this);
	}


	/**
	 * Change database user password
	 *
	 * @param  int $serverId
	 * @param  int $databaseUserId
	 * @return DatabaseUser
	 *
	 */
	public function changeDatabaseUserPassword(int $serverId, int $databaseUserId, string $password)
	{
		$data = compact('password');
		$dbUser = $this->patch("servers/{$serverId}/databaseusers/{$databaseUserId}", $data);
		return new DatabaseUser($dbUser, $this);
	}


	/**
	 * Delete database user
	 *
	 * @param  int $serverId
	 * @param  int $databaseUserId
	 * @return DatabaseUser
	 *
	 */
	public function deleteDatabaseUser(int $serverId, int $databaseUserId)
	{
		$dbUser = $this->delete("servers/{$serverId}/databaseusers/{$databaseUserId}");
		return new DatabaseUser($dbUser, $this);
	}


	/**
	 * Attach database user to database
	 *
	 * @param  int $serverId
	 * @param  int $databaseId
	 * @param  int $databaseUserId
	 * @return DatabaseUser
	 *
	 */
	public function attachDatabaseUser(int $serverId, int $databaseId, int $databaseUserId)
	{
		$data = ['id' => $databaseUserId];
		$dbUser = $this->post("servers/{$serverId}/databases/{$databaseId}/grant", $data);
		return new DatabaseUser($dbUser, $this);
	}


	/**
	 * Revoke database user from database
	 *
	 * @param  int $serverId
	 * @param  int $databaseId
	 * @param  int $databaseUserId
	 * @return DatabaseUser
	 *
	 */
	public function revokeDatabaseUser(int $serverId, int $databaseId, int $databaseUserId)
	{
		$data = ['id' => $databaseUserId];
		$dbUser = $this->delete("servers/{$serverId}/databases/{$databaseId}/grant", $data);
		return new DatabaseUser($dbUser, $this);
	}


}
