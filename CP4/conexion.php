<?php
class conexion extends PDO
{
private $manejador='mysql';
private $host='localhost';
private $nombre_base='celulares';
private $usuario='root';
private $contrasena='';

public function __construct(){
 try
  {
  parent::__construct("{$this->manejador}:dbname={$this->nombre_base};host={$this->host};charset=utf8",$this->usuario,$this->contrasena);
} catch (PDOException $e){
  echo 'Existe un error '.$e->getMessage();
}
}
}
?>