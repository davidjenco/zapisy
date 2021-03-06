<?php
require_once "db.php";

if(!isset($_POST['action'])) {
  echo "ERROR: No action specified";
  exit(0);
}

if(!isset($_POST['iid'])) {
  echo "ERROR: InstanceID not set";
}

switch($_POST['action']) {
  case 'getRequestId':
    echo '{"status":"OK","nonce":"' . DB::getActionID($_POST['iid']) . '"}';
    break;
  case 'addExam':
    DB::addExam($_POST['iid'], $_POST['nonce'], $_POST['subject'], $_POST['range'], $_POST['date'], isset($_POST['code']) ? $_POST['code'] : false);
    break;
  case 'deleteExam':
    DB::deleteExam($_POST['iid'], $_POST['nonce'], $_POST['eid'], isset($_POST['code']) ? $_POST['code'] : false);
    break;
  case 'updateExam':
    DB::updateExam($_POST['iid'], $_POST['nonce'], $_POST['eid'], $_POST['range'], $_POST['date'], isset($_POST['code']) ? $_POST['code'] : false);
    break;
  case 'attachLink':
    DB::attachFile($_POST['iid'], $_POST['nonce'], $_POST['eid'], 'link', $_POST['link']);
    break;
  case 'login':
    DB::login($_POST['code']);
    break;
  default:
    echo "ERROR: Unknown action";
    exit(0);
}
?>