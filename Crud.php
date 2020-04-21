<?php
interface Crud{
    public function save(mysqli $conn);
    public function readAll(mysqli $conn);
    public function readUnique();
    public function search();
    public function update();
    public function removeOne();
    public function removeAll();
}
?>