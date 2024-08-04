<?php
namespace App\Casino\Modele\DataObject;
abstract class AbstractDataObject {
    public function __construct() {
    }
    public function __toString() {
    }

    public abstract function formatTableau(): array;

}
?>