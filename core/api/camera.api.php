<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

header('Content-Type: application/json');
require_once dirname(__FILE__) . "/../../../../core/php/core.inc.php";
global $jsonrpc;
GLOBAL $_USER_GLOBAL;
if (!is_object($jsonrpc)) {
	throw new Exception(__('JSONRPC object not defined', __FILE__), -32699);
}

$params = $jsonrpc->getParams();

$request = file_get_contents("php://input");
$request = json_decode($request, true);

$secureLog = $params;
if (isset($secureLog['apikey'])) $secureLog['apikey'] = substr($secureLog['apikey'], 0, 10) . '...';
if (isset($secureLog['api'])) $secureLog['api'] = substr($secureLog['api'], 0, 10) . '...';

log::add('camera', 'debug', '┌──────────▶︎:fg-warning: Call API :/fg:◀︎─────────────');
log::add('camera', 'debug', '| params ─▶︎ ' . json_encode($secureLog));
log::add('camera', 'debug', '| request ─▶︎ ' . json_encode($request));
log::add('camera', 'debug', '| Method ─▶︎ ' . $jsonrpc->getMethod());

$eqLogic = null;
$ipClient = getClientIp();

if (isset($params['id'])) {
	// Search equipment by ID
	$eqLogic = eqLogic::byId($params['id']);
	if (!is_object($eqLogic)) {
		throw new Exception(__('EqLogic introuvable :', __FILE__) . ' ' . secureXSS($params['id']), -32602);
	}
	log::add('camera', 'debug', '| ' . __("Equipement trouvé par Id", __FILE__) . ' -> ' . $eqLogic->getHumanName());
  
} else {
	// Search equipment by ipClient
	$eqpts = eqLogic::byTypeAndSearchConfiguration('camera', '"ip":"' . $ipClient . '"', true);
	foreach ($eqpts as $eqpt) {
		$eqLogic = $eqpt;
		log::add('camera', 'debug', '| ' . __("Equipement trouvé par IP", __FILE__) . ' -> ' . $eqLogic->getHumanName());
		break;
	}
}

if (!is_object($eqLogic)) {
	throw new Exception(__('Aucun équipement ne correspond a la demande.', __FILE__));
}
if ($eqLogic->getEqType_name() != 'camera') {
	throw new Exception(__("l'eqLogic n'est pas un équipement du plugin camera.", __FILE__));
}

if ($jsonrpc->getMethod() == 'push::alarm') {

	///// REOLINK
	foreach ($request as $key => $value) {
		if (is_array($value) && count($value) > 0) {
			foreach ($value as $subKey => $subValue) {
				if (is_array($subValue)) continue;
				log::add('camera', 'debug', '| ' . $key . '::' . $subKey . ' = ' . $subValue);
				$eqLogic->checkAndUpdateCmd($key . '::' . $subKey, $subValue);
			}
		} else {
			log::add('camera', 'debug', '|----------- ' . $key . ' = ' . $value);
		}
	}
	//e.g ->  {"alarm":{"alarmTime":"2026-10-31T10:56:45.000+0000","channel":0,"channelName":"1","device":"Entree","deviceModel":"Reolink TrackMix PoE","message":"Person Detected from Entree","name":"Person Detected from Entree","title":"Camera Alert","type":"PEOPLE"}

	$jsonrpc->makeSuccess('success');
}
throw new Exception(__('Aucune méthode correspondante :', __FILE__) . ' ' . secureXSS($jsonrpc->getMethod()), -32500);