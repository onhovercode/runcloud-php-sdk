<?php

namespace OnHover\RunCloud\Actions;

use OnHover\RunCloud\Resources\WebApp;
use OnHover\RunCloud\Resources\Git;
use OnHover\RunCloud\Resources\Script;
use OnHover\RunCloud\Resources\Domain;
use OnHover\RunCloud\Resources\SSL;
use OnHover\RunCloud\Resources\Log;


trait ManagesWebApps
{


	/**
	 * Create a new web application.
	 *
	 * @param  int $serverId
	 * @param  array $data
	 * @return WebApp
	 *
	 */
	public function createWebApp(int $serverId, array $data = [])
	{
		$webapp = $this->post("servers/{$serverId}/webapps/custom", $data);
		return new WebApp($webapp, $this);
	}


	/**
	 * Get the collection of web applications.
	 *
	 * @param int $serverId
	 * @return WebApp[]
	 *
	 */
	public function webApps(int $serverId, string $search = '')
	{
		$query = ['search' => $search];
		$query = array_filter($query, 'strlen');

		$response = $this->getAllData("servers/{$serverId}/webapps", $query);
		return $this->transformCollection($response, WebApp::class);
	}


	/**
	 * Get a webapp.
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @return WebApp
	 *
	 */
	public function webApp(int $serverId, int $webAppId)
	{
		$webapp = $this->get("servers/{$serverId}/webapps/{$webAppId}");
		return new WebApp($webapp, $this);
	}


	/**
	 * Set Default Application
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @return WebApp
	 *
	 */
	public function setDefaultWebApp(int $serverId, int $webAppId)
	{
		$webapp = $this->post("servers/{$serverId}/webapps/{$webAppId}/default");
		return new WebApp($webapp, $this);
	}


	/**
	 * Remove Default Application
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @return WebApp
	 *
	 */
	public function unsetDefaultWebApp(int $serverId, int $webAppId)
	{
		$webapp = $this->delete("servers/{$serverId}/webapps/{$webAppId}/default");
		return new WebApp($webapp, $this);
	}


	/**
	 * Rebuild web application
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @return WebApp
	 *
	 */
	public function rebuildWebApp(int $serverId, int $webAppId)
	{
		$webapp = $this->post("servers/{$serverId}/webapps/{$webAppId}/rebuild");
		return new WebApp($webapp, $this);
	}


	/**
	 * Clone Git repository
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @param  array $data
	 * @return Git
	 *
	 */
	public function cloneGitRepo(int $serverId, int $webAppId, array $data)
	{
		$git = $this->post("servers/{$serverId}/webapps/{$webAppId}/git", $data);
		return new Git($git, $this);
	}


	/**
	 * Get Git details for web application
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @return Git
	 *
	 */
	public function git(int $serverId, int $webAppId)
	{
		$git = $this->get("servers/{$serverId}/webapps/{$webAppId}/git");
		return new Git($git, $this);
	}


	/**
	 * Change Git branch
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @param  int $gitId
	 * @param  string $branch
	 * @return Git
	 *
	 */
	public function gitBranch(int $serverId, int $webAppId, int $gitId, string $branch)
	{
		$data = ['branch' => $branch];
		$git = $this->patch("servers/{$serverId}/webapps/{$webAppId}/git/{$gitId}/branch", $data);
		return new Git($git, $this);
	}


	/**
	 * Git deployment script
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @param  int $gitId
	 * @param  array $data
	 * @return Git
	 *
	 */
	public function gitDeployScript(int $serverId, int $webAppId, int $gitId, array $data)
	{
		$git = $this->patch("servers/{$serverId}/webapps/{$webAppId}/git/{$gitId}/script", $data);
		return new Git($git, $this);
	}


	/**
	 * Git Force Deploy
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @param  int $gitId
	 * @return string
	 *
	 */
	public function forceGitDeploy(int $serverId, int $webAppId, int $gitId)
	{
		$response = $this->put("servers/{$serverId}/webapps/{$webAppId}/git/{$gitId}/script");
		return $response;
	}


	/**
	 * Remove Git
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @param  int $gitId
	 * @return Git
	 *
	 */
	public function removeGit(int $serverId, int $webAppId, int $gitId)
	{
		$git = $this->delete("servers/{$serverId}/webapps/{$webAppId}/git/{$gitId}");
		return new Git($git, $this);
	}


	/**
	 * Install PHP Script
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @param  string $name
	 * @return Script
	 *
	 */
	public function installScript(int $serverId, int $webAppId, string $name)
	{
		$data = ['name' => $name];
		$script = $this->post("servers/{$serverId}/webapps/{$webAppId}/installer", $data);
		return new Script($script, $this);
	}


	/**
	 * Get Script
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @return Script
	 *
	 */
	public function script(int $serverId, int $webAppId)
	{
		$script = $this->get("servers/{$serverId}/webapps/{$webAppId}/installer");
		return new Script($script, $this);
	}


	/**
	 * Remove Script
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @param  int $scriptId
	 * @return Script
	 *
	 */
	public function removeScript(int $serverId, int $webAppId, int $scriptId)
	{
		$script = $this->delete("servers/{$serverId}/webapps/{$webAppId}/installer/{$scriptId}");
		return new Script($script, $this);
	}


	/**
	 * Add domain name
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @param  string $name
	 * @return Domain
	 *
	 */
	public function addDomain(int $serverId, int $webAppId, string $name)
	{
		$data = ['name' => $name];
		$domain = $this->post("servers/{$serverId}/webapps/{$webAppId}/domains", $data);
		return new Domain($domain, $this);
	}


	/**
	 * List domains
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @return Domain[]
	 *
	 */
	public function domains(int $serverId, int $webAppId)
	{
		$response = $this->getAllData("servers/{$serverId}/webapps/{$webAppId}/domains");
		return $this->transformCollection($response, Domain::class);
	}


	/**
	 * Delete domain
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @param  int $domainId
	 * @return Domain
	 *
	 */
	public function deleteDomain(int $serverId, int $webAppId, int $domainId)
	{
		$domain = $this->delete("servers/{$serverId}/webapps/{$webAppId}/domains/{$domainId}");
		return new Domain($domain, $this);
	}


	/**
	 * Install SSL
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @param  array $data
	 * @return SSL
	 *
	 */
	public function installSSL(int $serverId, int $webAppId, array $data)
	{
		$ssl = $this->post("servers/{$serverId}/webapps/{$webAppId}/ssl", $data);
		return new SSL($ssl, $this);
	}


	/**
	 * SSL
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @return SSL
	 *
	 */
	public function SSL(int $serverId, int $webAppId)
	{
		$ssl = $this->get("servers/{$serverId}/webapps/{$webAppId}/ssl");
		return new SSL($ssl, $this);
	}


	/**
	 * Update SSL
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @param  int $sslId
	 * @param  array $data
	 * @return SSL
	 *
	 */
	public function updateSSL(int $serverId, int $webAppId, int $sslId, array $data)
	{
		$ssl = $this->patch("servers/{$serverId}/webapps/{$webAppId}/ssl/{$sslId}", $data);
		return new SSL($ssl, $this);
	}


	/**
	 * Redeploy SSL
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @param  int $sslId
	 * @param  array $data
	 * @return SSL
	 *
	 */
	public function redeploySSL(int $serverId, int $webAppId, int $sslId)
	{
		$ssl = $this->put("servers/{$serverId}/webapps/{$webAppId}/ssl/{$sslId}");
		return new SSL($ssl, $this);
	}


	/**
	 * Delete SSL
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @param  int $sslId
	 * @return SSL
	 *
	 */
	public function deleteSSL(int $serverId, int $webAppId, int $sslId)
	{
		$ssl = $this->delete("servers/{$serverId}/webapps/{$webAppId}/ssl/{$sslId}");
		return new SSL($ssl, $this);
	}


	/**
	 * Settings
	 *
	 * @param  int $serverId
	 * @param  int $webAppId
	 * @return []
	 *
	 */
	public function webAppSettings(int $serverId, int $webAppId)
	{
		$response = $this->get("servers/{$serverId}/webapps/{$webAppId}/settings");
		return $response;
	}


	/**
	 * Change PHP Version
	 *
	 * @param  int    $serverId
	 * @param  int    $webAppId
	 * @param  string $version
	 * @return WebApp
	 *
	 */
	public function changeWebAppPHPVersion(int $serverId, int $webAppId, string $version)
	{
		$data = ['phpVersion' => $version];
		$webapp = $this->patch("servers/{$serverId}/webapps/{$webAppId}/settings/php", $data);
		return new WebApp($webapp, $this);
	}


	/**
	 * Update FPM/Nginx settings
	 *
	 * @param  int    $serverId
	 * @param  int    $webAppId
	 * @param  array  $data
	 * @return WebApp
	 *
	 */
	public function updateWebAppFPMNginx(int $serverId, int $webAppId, array $data)
	{
		$webapp = $this->patch("servers/{$serverId}/webapps/{$webAppId}/settings/fpmnginx", $data);
		return new WebApp($webapp, $this);
	}


	/**
	 * Get Web Application event log
	 *
	 * @param  int    $serverId
	 * @param  int    $webAppId
	 * @param  string $search
	 * @return Log[]
	 *
	 */
	public function webAppLog(int $serverId, int $webAppId, string $search = '')
	{
		$query = ['search' => $search];
		$query = array_filter($query, 'strlen');

		$response = $this->getAllData("servers/{$serverId}/webapps/{$webAppId}/log", $query);
		return $this->transformCollection($response, Log::class);
	}


	/**
	 * Delete Web Application
	 *
	 * @param  int    $serverId
	 * @param  int    $webAppId
	 * @return WebApp
	 *
	 */
	public function deleteWebApp(int $serverId, int $webAppId)
	{
		$webapp = $this->delete("servers/{$serverId}/webapps/{$webAppId}");
		return new WebApp($webapp, $this);
	}


}
