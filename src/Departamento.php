<?php
namespace Empresa;
use Faker;
use PDO;
use PDOException;

    class Departamento extends Conexion{
        private $id;
        private $nombre;
        private $descripcion;


        public function __construct()
        {
            parent::__construct();
        }

        //-------------------FUNCTIONS-----------//

        public function create(){
            $q = "insert into departamentos (nombre,descripcion) values (:n,:d)";
            $stmt = parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':n'=>$this->nombre,
                    ':d'=>$this->descripcion
                ]);
            } catch(PDOException $ex){
            die("Error al crear departamento: " . $ex->getMessage());
            }
            parent::$conexion=null;
        }

        public function read($id){
            $q="select * from departamentos where id=:i";
            $stmt = parent::$conexion->prepare($q);
            try {
                $stmt->execute([
                    ':i' => $id
                ]);
            } catch (PDOException $ex) {
                die("Error al leer la categoria: " . $ex->getMessage());
            }
            parent::$conexion = null;
            return $stmt->fetch(PDO::FETCH_OBJ);
        }


        public function update(){

        }

        public function generarDepartamento($cant){
            //Si no existen creo los Departamentos
            if ($this->hayDepartamentos()==0){
                $faker = Faker\Factory::create('es_Es');
                for ($i=0; $i<$cant; $i++){
                    $nombre = $faker -> unique()->randomElement($dep=array('Informatica','Recursos Humanos','Financiero','Marketing','Comercial','Logística y operaciones','Control de gestión'));
                    $descripcion = $faker -> text(15);
                    (new Departamento)->setNombre($nombre)
                    ->setDescripcion($descripcion)
                    ->create();
                }
            }
        }

        public function hayDepartamentos(){
            $q="select * from departamentos";
            $stmt = parent::$conexion->prepare($q);
            try{
                $stmt->execute();
                parent::$conexion=null;
            } catch (PDOException $ex){
                die ("No hay departamentos" . $ex->getMessage());
            }
    
            return $stmt -> rowCount(); //Devolvemos el número de filas
        }

        public function readAll(){
            $q="select * from departamentos order by id";
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute();
            }catch (PDOException $ex){
                die("Error al recuperar todos los datos: ".$ex->getMessage());
            }
            parent::$conexion=null; //cerramos la conexion
            return $stmt;
        }    

        public function devolverIdDepart(){
            $q="select id from departamentos order by id";
            $stmt = parent::$conexion->prepare($q);
            try{
                $stmt->execute();
            }catch(PDOException $ex){
                die("Error al devolver id del departamento: " . $ex->getMessage());
            }

            $id = [];
            while ($fila = $stmt->fetch(PDO::FETCH_OBJ)){
                $id[] = $fila->$id;
            }

            parent::$conexion = null;
            return $id;
        }


        //-----GETTER AND SETTER--------------------------//

        


        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of nombre
         */ 
        public function getNombre()
        {
                return $this->nombre;
        }

        /**
         * Set the value of nombre
         *
         * @return  self
         */ 
        public function setNombre($nombre)
        {
                $this->nombre = $nombre;

                return $this;
        }

        /**
         * Get the value of descripcion
         */ 
        public function getDescripcion()
        {
                return $this->descripcion;
        }

        /**
         * Set the value of descripcion
         *
         * @return  self
         */ 
        public function setDescripcion($descripcion)
        {
                $this->descripcion = $descripcion;

                return $this;
        }
}
