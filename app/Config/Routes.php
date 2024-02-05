<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('home', 'Home::index');
$routes->get('player', 'Player::player');
$routes->post('addPlayerAndMapToLeague', 'Player::addPlayerAndMapToLeague');
$routes->post('updatePlayerData', 'Player::updatePlayerData');
$routes->post('updatePlayerTeam', 'Player::updatePlayerTeam');
// $routes->get('player', 'Player::addPlayer');
$routes->get('addleague', 'AddLeague::League');
$routes->post('addleaguedata', 'AddLeague::addLeague');
$routes->get('league', 'League::League');

$routes->get('getPlayersByTeamId/(:num)', 'League::getPlayersByTeamId/$1');
$routes->get('/', 'Test::Test');
$routes->get('test/player', 'Test::player'); // Adjust the URI segment if needed

