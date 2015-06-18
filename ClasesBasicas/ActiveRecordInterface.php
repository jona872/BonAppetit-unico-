<?php
interface ActiveRecord {
   public function findAll();

   public function find($oValueObject);

   public function insert($oValueObject);

   public function update($oValueObject);

   public function delete($oValueObject);

   public function exists($oValueObject);

   public function count();
}
?>