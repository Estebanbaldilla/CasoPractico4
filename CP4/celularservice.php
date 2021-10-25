<?php
require_once 'conexion.php';
require_once 'lib/nusoap.php';
//Metodo para insertar celulares
function insertCelular($modelo,$memoria_ram,$sistema_operativo,$memoria_interna){
    try {
       $conexion = new conexion();
       $consulta=$conexion->prepare("INSERT INTO Celular (id,Modelo,Sistema_operativo,Memoria_ram,Memoria_interna)
         VALUES ('0',:modelo, :sistema_operativo, :memoria_ram, :memoria_interna)");
       $consulta -> bindParam(":modelo", $modelo, PDO::PARAM_STR);
       $consulta -> bindParam(":sistema_operativo", $sistema_operativo, PDO::PARAM_STR);
       $consulta -> bindParam(":memoria_ram",$memoria_ram, PDO::PARAM_STR);
       $consulta -> bindParam(":memoria_interna",$memoria_interna, PDO::PARAM_STR);
       $consulta ->execute();
       $ultimoID= $conexion->lastInsertId();
       return join(",", array($ultimoID));
    } catch (Exeption $e) {
       
        return join(",", array(false));
    }
}
//Metodo para borrar celulares
function borrarCelular($id){
  try {
     $conexion = new conexion();
     $consulta=$conexion->prepare("DELETE FROM Celular WHERE id=?");
     $consulta ->execute( array($id));
    $res=$consulta->rowCount();//filasafectadas
    if($res >0)
     return join(",", array(true));
    else
    return join(",", array(false));
    return join(",", array($lastInserId));
  } catch (Exeption $e) {
     
      return join(",", array(false));
  }
}
//Metodo para modificar celulares
function modificarCelular($id,$modelo,$memoria_ram,$sistema_operativo,$memoria_interna){
  try {
     $conexion = new conexion();
     $consulta=$conexion->prepare("UPDATE celular SET
      Modelo = :modelo, 
      Sistema_operativo = :sistema_operativo, 
      Memoria_ram = :memoria_ram, 
      Memoria_interna = memoria_interna 
      WHERE celular.id = :id");
       $consulta -> bindParam(":id", $id, PDO::PARAM_INT);
      $consulta -> bindParam(":modelo", $modelo, PDO::PARAM_STR);
      $consulta -> bindParam(":sistema_operativo", $sistema_operativo, PDO::PARAM_STR);
      $consulta -> bindParam(":memoria_ram",$memoria_ram, PDO::PARAM_STR);
      $consulta -> bindParam(":memoria_interna",$memoria_interna, PDO::PARAM_STR);
     $consulta ->execute();
    return join(",", array("Modificado", $id));
  } catch (Exeption $e) {
     
      return join(",", array(false));
  }
}
// Aqui inicia el  registro del servicio soap
$server= new nusoap_server();
$server ->configureWSDL("celularservice","urn:celularservice");
//insertar celualar
$server->register("insertCelular",
array("modelo"=>"xsd:string","sistema_operativo"=>"xsd:string","memoria_ram"=>"xsd:string","memoria_interna"=>"xsd:string"),
array("return"=>"xsd:string"),
"urn:celularservice",
"urn:celularservice#insertCelular",
"rpc",
"encoded",
"Metodo que inserta un celular");
//borrar celular
$server->register("borrarCelular",
array("id"=>"xsd:string"),
array("return"=>"xsd:string"),
"urn:celularservice",
"urn:celularservice#borrarCelular",
"rpc",
"encoded",
"Metodo que borra un celular");
//modificar celular
$server->register("modificarCelular",

array("id"=>"xsd:Decimal","modelo"=>"xsd:string","sistema_operativo"=>"xsd:string","memoria_ram"=>"xsd:string","memoria_interna"=>"xsd:string"),
array("return"=>"xsd:string"),
"urn:celularservice",
"urn:celularservice#insertCelular",
"rpc",
"encoded",
"Metodo que modifica un celular");
//flujo de solo lectura que permite leer datos del cuerpo solicitado
$post = file_get_contents('php://input');
$server->service($post);
?>