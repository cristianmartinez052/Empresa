<?php

namespace Empresa;

use PDO;
use PDOException;
use Faker;

class Empleado extends Conexion
{
    private $id;
    private $nombre;
    private $apellidos;
    private $pais;
    private $email;
    private $img;
    private $departamento_id;

    public function __construct()
    {
        parent::__construct();
    }



    //------------FUNCTIONS-----------------------//
    public function create()
    {
        $q = "insert into empleados(nombre, apellidos, pais, email, img, departamento_id) values (:n,:a,:p,:e,:i,:di)";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':a' => $this->apellidos,
                ':p' => $this->pais,
                ':e' => $this->email,
                ':i' => $this->img,
                ':di' => $this->departamento_id
            ]);
        } catch (PDOException $ex) {
            die("Error al crear empleado" . $ex->getMessage());
        }

        parent::$conexion = null;
    }

    public function update()
    {
    }

    public function delete()
    {
    }

    public function read()
    {
    }

    //Metodo generar empleados con faker , usa el create

    public function generarEmpleados($cant)
    {
        if (!$this->hayEmpleados()) {
            $faker = Faker\Factory::create('es_ES');
            $departamento = (new Departamento)->devolverIdDepart();
            $APP_URL="http://127.0.0.1/DesarrolloServidor/Practicas/Empresa/public/";
            for ($i = 0; $i < $cant; $i++) {
                $nombre = $faker->firstName();
                $apellidos = $faker-> lastName() . " " . $faker->lastName();
                $pais = $faker->country();
                $email = $faker-> freeEmail();
                $img = $APP_URL."img/default.png";
                $departamento_id = $departamento[array_rand($departamento,1)];
                (new Empleado) ->setNombre($nombre)
                ->setApellidos($apellidos)
                ->setPais($pais)
                ->setEmail($email)
                ->setImg($img)
                ->setDepartamento_id($departamento_id)
                ->create();
            }
        }
    }

    //Funcion que verifica si hay empleados o no 

    public function hayEmpleados()
    {
        $q = "select * from empleados";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al comprobar empleados" . $ex->getMessage());
        }
        $totalEmpleados = $stmt->rowCount();
        parent::$conexion = null;
        return ($totalEmpleados > 0);
    }

    //Método que nos devuelve todos los datos

    public function readAll(){
        $q="select * from empleados order by nombre";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al devolver todos los empleados: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt;
    }



    //----------------------------GETTER AND SETTER--------------------------//



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
     * Get the value of apellidos
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set the value of apellidos
     *
     * @return  self
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of img
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set the value of img
     *
     * @return  self
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get the value of departamento_id
     */
    public function getDepartamento_id()
    {
        return $this->departamento_id;
    }

    /**
     * Set the value of departamento_id
     *
     * @return  self
     */
    public function setDepartamento_id($departamento_id)
    {
        $this->departamento_id = $departamento_id;

        return $this;
    }

    /**
     * Get the value of pais
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set the value of pais
     *
     * @return  self
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }
}
