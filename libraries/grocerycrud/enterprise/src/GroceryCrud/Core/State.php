<?php
namespace GroceryCrud\Core;

class State
{
    const MAIN_STATE = 'Main';

    protected function isUploadStream() {
        return !empty($_GET['action']) && in_array($_GET['action'], ['upload']);
    }

	public function getStateName()
    {
        switch($this->getRequestMethod()) {
            case 'get':
                $action = !empty($_GET['action']) ? $_GET['action'] : null;
                break;

            case 'post':
                if ($this->isUploadStream()) {
                    $action = $_GET['action'];
                } else {
                    $action = !empty($_POST['action']) ? $_POST['action'] : null;
                }

                break;

            default:
                throw new \Exception("Unrecognized request method: " . $this->getRequestMethod());
                break;
        }

        if (empty($action)) {
            return State::MAIN_STATE;
        }

        if (!empty($action) && $this->isStateValid($action)) {
            if (strstr($action, '-')) {
                return $this->ucFirstDash($action);
            }

            return ucfirst($action);
        }

        throw new \Exception("Either, the action name is not recognized. Either the API method is wrong.");
    }

    private function getRequestMethod() {
        if(php_sapi_name() !== 'cli') {
            return strtolower($_SERVER['REQUEST_METHOD']);
        }

        return 'get';
    }

    private function ucFirstDash($wordWithDashes) {
        return implode("", array_map(function ($word) {
            return ucfirst($word);
        }, explode("-", $wordWithDashes)));
    }

    private function isStateValid($state) {
        if ($this->getRequestMethod() === 'post' && in_array($state, [
                'insert',
                'update',
                'remove-one',
                'remove-multiple',
                'upload',
                'delete-file'
            ])) {
            return true;
        }

        return in_array(
            $state,
            ['datagrid', 'totals', 'export',
                'print', 'add-form', 'edit-form',
                'read-form', 'initial', 'remove-cache']
        );
    }
}