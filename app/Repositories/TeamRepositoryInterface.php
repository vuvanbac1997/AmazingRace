<?php namespace App\Repositories;

interface TeamRepositoryInterface extends SingleKeyModelRepositoryInterface
{
	public function checkTeam($username);
}