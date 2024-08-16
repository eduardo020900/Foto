<?php

require_once 'Banco.php';
require_once 'Conexao.php';

class Foto extends Banco{

    private $id;
    private $foto;
    private $fotoTipo;
    private $caminhoFoto;


    

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getFoto(){
        return $this->foto;
    }

    public function setFoto($foto){
        $this->foto = $foto;
    }

   
    public function getFotoTipo(){
        return $this->fotoTipo;
    }

    public function setFotoTipo($fotoTipo){
        $this->fotoTipo = $fotoTipo;
    }

    public function getCaminhoFoto(){
        return $this->caminhoFoto;
    }

    public function setCaminhoFoto($caminhoFoto){
        $this->caminhoFoto = $caminhoFoto;
    }


    public function save() {
        $result = false;
        
        $conexao = new Conexao();
        
        if($conn = $conexao->getConection()){
            if($this->id > 0){
                
                $query = "UPDATE foto SET foto = :foto, fotoTipo = :fotoTipo, caminhoFoto = :caminhoFoto  WHERE id = :id";
                
                $stmt = $conn->prepare($query);
                
                if ($stmt->execute(
                    array(':foto' => $this->foto, ':id'=> $this->id, ':fotoTipo' => $this->fotoTipo, 'caminhoFoto' => $this->caminhoFoto))){
                    $result = $stmt->rowCount();
                }
            }else{
                
                $query = "insert into foto (id,  foto, fotoTipo, caminhoFoto) 
                values (null,:foto, :fotoTipo, :caminhoFoto)";
                
                $stmt = $conn->prepare($query);
                
                if ($stmt->execute(array(':foto' => $this->foto, ':fotoTipo'=>$this->fotoTipo, ':caminhoFoto' => $this->caminhoFoto))) {
                    $result = $stmt->rowCount();
                }
            }
        }
        return $result;
    }

    public function find($id) {

        
        $conexao = new Conexao();
        
        $conn = $conexao->getConection();
        
        $query = "SELECT * FROM foto where id = :id";
        
        $stmt = $conn->prepare($query);
        
        if ($stmt->execute(array(':id'=> $id))) {
            
            if ($stmt->rowCount() > 0) {
                
                $result = $stmt->fetchObject(Foto::class);
            }else{
                $result = false;
            }
        }
        return $result;
    }

    public function remove($id) {

        $result = false;
        
        $conexao = new Conexao();
        
        $conn = $conexao->getConection();
        
        $query = "DELETE FROM foto where id = :id";
        
        $stmt = $conn->prepare($query);
        
        if ($stmt->execute(array(':id'=> $id))) {
            $result = true;
        }
        return $result;
    }

    public function count() {
        
        $conexao = new Conexao();
        
        $conn = $conexao->getConection();
        
        $query = "SELECT count(*) FROM foto";
        
        $stmt = $conn->prepare($query);
        $count = $stmt->execute();
        if (isset($count) && !empty($count)) {
            return $count;
        }
        return false;
    }

    public function listAll() {

        
        $conexao = new Conexao();
        
        $conn = $conexao->getConection();
        
        $query = "SELECT * FROM foto";
        
        $stmt = $conn->prepare($query);
        
        $result = array();
        
        if ($stmt->execute()) {
            
            while ($rs = $stmt->fetchObject(Foto::class)) {
                
                $result[] = $rs;
            }
        }else{
            $result = false;
        }

        return $result;
    }
  
}

?>