<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\NetworkSession;

class VideoStreamConnectPacket extends DataPacket/* implements ClientboundPacket*/{
	public const NETWORK_ID = ProtocolInfo::VIDEO_STREAM_CONNECT_PACKET;

	public const ACTION_CONNECT = 0;
	public const ACTION_DISCONNECT = 1;

	/** @var string */
	public $serverUri;
	/** @var float */
	public $frameSendFrequency;
	/** @var int */
	public $action;

	protected function decodePayload() : void{
		$this->serverUri = $this->getString();
		$this->frameSendFrequency = $this->getLFloat();
		$this->action = $this->getByte();
	}

	protected function encodePayload() : void{
		$this->putString($this->serverUri);
		$this->putLFloat($this->frameSendFrequency);
		$this->putByte($this->action);
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleVideoStreamConnect($this);
	}
}
