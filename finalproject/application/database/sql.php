<?php

class sql extends dbconn {

    public function __construct() {
        $this->initDBO();
    }

    public function new_claim($datetime, $bus_num, $message) {
        $db = $this->dblocal;
        try {
            $stmt = $db->prepare("insert into personal_claim(datetime,bus_num,message) values (:datetime,:bus_num,:message)");
            $stmt->bindParam("datetime", $datetime);
            $stmt->bindParam("bus_num", $bus_num);
            $stmt->bindParam("message", $message);
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = "Success save claim";
            return $stat;
        } catch (PDOException $ex) {
            $stat[0] = false;
            $stat[1] = $ex->getMessage();
            return $stat;
        }
    }

    public function list_claim() {
        $db = $this->dblocal;
        try {
            $stmt = $db->prepare("select * from personal_claim");
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = "List claim";
            $stat[2] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            $stat[0] = false;
            $stat[1] = $ex->getMessage();
            $stat[2] = [];
            return $stat;
        }
    }

    public function edit_claim($id, $datetime, $bus_num, $message) {
        $db = $this->dblocal;
        try {
            $stmt = $db->prepare("update personal_claim set datetime = :datetime, bus_num = :bus_num, message = :message where id = :id ");
            $stmt->bindParam("id", $id);
            $stmt->bindParam("datetime", $datetime);
            $stmt->bindParam("bus_num", $bus_num);
            $stmt->bindParam("message", $message);
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = "Success edit claim";
            return $stat;
        } catch (PDOException $ex) {
            $stat[0] = false;
            $stat[1] = $ex->getMessage();
            return $stat;
        }
    }

    public function delete_claim($id) {
        $db = $this->dblocal;
        try {
            $stmt = $db->prepare("delete from personal_claim where id = :id");
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $stat[0] = true;
            $stat[1] = "Sucesso ao deletar reclamação";
            return $stat;
        } catch (PDOException $ex) {
            $stat[0] = false;
            $stat[1] = $ex->getMessage();
            return $stat;
        }
    }

}
