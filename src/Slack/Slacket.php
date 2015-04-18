<?php


use Slack\Client;
use Slack\Notifier;

use Slack\Message\Message;
use Slack\Message\MessageAttachment;

class Slacket {
    public $client;
    public $slack;
    public $message;
    public $attachments;
    public $username;

    private $team;
    private $token;

    public function __construct() {
        $this->team = 'rocketdept';
        $this->token = 'W65PkPbZMfuMfolFbmanbJVv';
        $this->username = 'RD Teamwork';

        $this->client = new Slack\Client($this->team, $this->token);
        $this->slack  = new Slack\Notifier($this->client);
        $this->attachments = array();
    }

    public function createMessage($message) {
        $this->message = new Slack\Message\Message($message);
        $this->message->setUsername($this->username);
        return $this;
    }

    public function createAttachment($index, $data) {
        $this->attachments[$index] = new Slack\Message\MessageAttachment();
        $this->attachments[$index]->setText($data['text']);
        $this->attachments[$index]->addTitle($data['title']);
        $this->attachments[$index]->setcolor($data['color']);

        $this->message->addAttachment($this->attachments[$index]);
        return $this;
    }

    public function createMessageField($attachment_index, $data) {
        $field = new Slack\Message\MessageField();
        $field->setTitle($data['title']);
        $field->setValue($data['value']);
        $field->setShort(true);
        $this->attachments[$attachment_index]->addField($field);
    }

    public function notify() {
        $this->slack->notify($this->message);
    }
}

?>
