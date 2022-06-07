<?php

namespace Misakstvanu\DschrankaApiLaravel;

class MessageBuilder {
    private $databox_id;

    public function __construct($databox_id){
        $this->databox_id = $databox_id;
    }

    private function getList($uri, $trashed = false, \DateTime $from = null, \DateTime $to = null){
        $response = HTTPClient::request('GET', $uri, [
            'trash' => $trashed,
            'from' => $from?->getTimestamp(),
            'to' => $to?->getTimestamp()
        ]);
        $list = [];
        foreach($response->json() as $message)
            array_push($list, Message::fromArray($message));
        return $list;
    }

    /**
     * @return array<Message>
     */
    function received($trashed = false, \DateTime $from = null, \DateTime $to = null){
        $uri = '/databox/'.$this->databox_id.'/messages/received';
        return $this->getList($uri, $trashed, $from, $to);
    }
    /**
     * @return array<Message>
     */
    function sent($trashed = false, \DateTime $from = null, \DateTime $to = null){
        $uri = '/databox/'.$this->databox_id.'/messages/sent';
        return $this->getList($uri, $trashed, $from, $to);
    }


}