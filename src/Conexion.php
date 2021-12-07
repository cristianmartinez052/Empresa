<?php
namespace Empresa;
use PDO;
use PDOException;

class Conexion{
    protected static $conexion;
    public function __construct()
    {
        if (self::$conexion==null){
            self::CrearConexion();
        }
    }

    public static function CrearConexion(){
        //Leemos los datos del archivo .config
        $fichero = dirname(__DIR__, 1) . "/.config";
        $opciones = parse_ini_file($fichero);
        $dbname = $opciones['dbname'];
        $host = $opciones['host'];
        $usuario = $opciones['user'];
        $pass = $opciones['pass'];

        //Creamos el DNS
        $dns = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        //Creamos la conexión en un bloque try-catch
        try{
            self::$conexion= new PDO($dns, $usuario, $pass);
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $ex){
            die("Error en la conexion!!!").$ex->getMessage();
        }
    }
}
