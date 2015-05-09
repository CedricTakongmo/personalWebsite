<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text; charset=UTF-8");

require_once('MysqliDb.php');

$db = new Mysqlidb('localhost', 'ctkn40', 'sn8AyGYH5jtPcQph', 'ctkn40');




switch (getGet("controller")) {
    case ("TrainingProgrammListCtrl"):
        $params = Array(0, (int) getGet("offset"), (int) getGet("start"));
        try {
            $resultArray = $db->rawQuery("select * from trainingprogram where deleteFlag = ?  ORDER BY id DESC limit ? OFFSET ?", $params);
        } catch (Exception $e) {
            $resultArray = $e->getMessage();
        }
        if (is_array($resultArray)) {
            if (count($resultArray) === 0) {
                $message = "No Data recorded";
            } else {
                $message = "Data Successfully get";
            }
            $jsonresult = array(
                'success' => true,
                'data' => $resultArray,
                'message' => $message
            );
        } else {
            $jsonresult = array(
                'success' => false,
                'data' => array(),
                'message' => $db->getLastError()
            );
        }
        break;
    case ("updateTrainingProgrammCtrl"):
        $isTraining = getGet("Training");
        if ($isTraining) {
            $Training = json_decode($isTraining);
            if ($Training->Name !== "" || $Training->Datum !== "" || $Training->Frequenz !== "" || $Training->Description !== "" || $Training->ImageSrc !== "") {
                $params = Array($Training->Name, $Training->Datum, $Training->Frequenz, $Training->Description, $Training->ImageSrc, $Training->id);
                try {
                    $executionResult = $db->rawQuery("UPDATE trainingprogram SET Name =?, Datum=? , Frequenz =?, Description=? , ImageSrc =? WHERE id=?", $params);
                } catch (Exception $e) {
                    $executionResult = $e->getMessage();
                }
                if (is_array($executionResult)) {
                    $jsonresult = array(
                        'success' => true,
                        'data' => $executionResult,
                        'message' => "Fields successfully updated"
                    );
                } else {
                    $jsonresult = array(
                        'success' => false,
                        'data' => array(),
                        'message' => $db->getLastError()
                    );
                }
            } else {
                $jsonresult = array(
                    'success' => false,
                    'data' => array(),
                    'message' => "Please fill all fields!"
                );
            }
        } else {
            $jsonresult = array(
                'success' => false,
                'data' => array(),
                'message' => "No Training Object send"
            );
        }
        break;
    case ("deleteTrainingProgrammCtrl"):
        $TrainingProgramid = (int) getGet("TrainingProgramid");
        $deleteFlag = (int) getGet("deleteFlag");
        if ($TrainingProgramid && ($deleteFlag == 0 || $deleteFlag == 1)) {
            $params = Array($deleteFlag, $TrainingProgramid);
            try {
                $executionResult = $db->rawQuery("UPDATE trainingprogram SET deleteFlag =? WHERE id=?", $params);
            } catch (Exception $e) {
                $executionResult = $e->getMessage();
            }
            if (is_array($executionResult)) {
                $jsonresult = array(
                    'success' => true,
                    'data' => $executionResult,
                    'message' => "Fields successfully deleted"
                );
            } else {
                $jsonresult = array(
                    'success' => false,
                    'data' => array(),
                    'message' => $executionResult
                );
            }
        } else {
            $jsonresult = array(
                'success' => false,
                'data' => array(),
                'message' => "No id or deleteFlag set"
            );
        }
        break;
    case ("insertTrainingProgrammCtrl"):
        $isTraining = getGet("Training");
        if ($isTraining) {
            $Training = json_decode($isTraining);
            if ($Training->Name !== "" || $Training->Datum !== "" || $Training->Frequenz !== "" || $Training->Description !== "" || $Training->ImageSrc !== "") {
                $params = Array($Training->Name, $Training->Datum, $Training->Frequenz, $Training->Description, $Training->ImageSrc);
                try {
                    $executionResult = $db->rawQuery("INSERT INTO trainingprogram (Name, Datum, Frequenz, description, ImageSrc) VALUES (?, ?, ?, ?, ?)", $params);
                } catch (Exception $e) {
                    $executionResult = $e->getMessage();
                }
                if (is_array($executionResult)) {
                    $jsonresult = array(
                        'success' => true,
                        'data' => $executionResult,
                        'message' => "Fields successfully insered"
                    );
                } else {
                    $jsonresult = array(
                        'success' => false,
                        'data' => array(),
                        'message' => $executionResult
                    );
                }
            } else {
                $jsonresult = array(
                    'success' => false,
                    'data' => array(),
                    'message' => "Please fill all fields!"
                );
            }
        } else {
            $jsonresult = array(
                'success' => false,
                'data' => array(),
                'message' => "No Training Object send"
            );
        }
        break;
    case ("selectATrainingProgram"):
        $TrainingProgramid = (int) getGet("TrainingProgramid");
        if ($TrainingProgramid) {
            $params = Array($TrainingProgramid);
            try {
                $resultArray = $db->rawQuery("SELECT id, Name, Datum, Frequenz, Description, ImageSrc FROM trainingprogram WHERE deleteFlag =0 AND id =?", $params);
            } catch (Exception $e) {
                $resultArray = $e->getMessage();
            }
            if (is_array($resultArray)) {
                if (count($resultArray) === 0) {
                    $message = "The element was probably deleted";
                } else {
                    $message = "Data Successfully get";
                }
                $jsonresult = array(
                    'success' => true,
                    'data' => $resultArray,
                    'message' => $message
                );
            } else {
                $jsonresult = array(
                    'success' => false,
                    'data' => array(),
                    'message' => $resultArray
                );
            }
        } else {
            $jsonresult = array(
                'success' => false,
                'data' => array(),
                'message' => "An Error occurred. Training program id not found"
            );
        }
        break;
    default :
        $params = Array();
        try {
            $resultArray = $db->rawQuery("SELECT * FROM kalender", $params);
        } catch (Exception $e) {
            $resultArray = $e->getMessage();
        }
        if (is_array($resultArray)) {
            $jsonresult = array(
                'success' => true,
                'data' => $resultArray,
                'message' => "Data Successfully get"
            );
        } else {
            $jsonresult = array(
                'success' => false,
                'data' => array(),
                'message' => $resultArray
            );
        }
}


echo json_encode($jsonresult);

function getGet($index) {
    $result = null;
    if (isset($_GET[$index])) {
        $result = $_GET[$index];
    }
    return $result;
}
