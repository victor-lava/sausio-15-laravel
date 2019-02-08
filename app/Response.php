<?php

namespace App;

class Response
{
    public $status;
    public $message;
    public $data;

    public function __construct() {
        $this->status = 404;
        $this->message = $this->createStatusMessage($this->status);
        $this->data = null;
    }

    public function status(int $code) {
        $this->status = $code;
        $this->message = $this->createStatusMessage($code);
    }

    public function data(object $data) {
        $this->data = $data;
    }

    private function createStatusMessage(int $code) {
        switch ($code) {
            case 200:
                $message = 'OK';
                break;
            case 204:
                $message = 'No content';
                break;
            case 404:
                $message = 'Not Found';
                break;
            default:
                $message = 'Unkown status message';
                break;
        }

        return $message;
    }

    public function json() {
        return response()->json($this, $this->status);
    }


}
