<?php

class Szalamik {
    private $id;
    private $marka;
    private $iz;
    private $husfajta;
    private $kiszereles;
    private $eltarthatosag;
    private $laktozmentes;

    public function __construct(string $marka, string $iz, string $husfajta, int $kiszereles, DateTime $eltarthatosag, string $laktozmentes) {
        $this -> marka = $marka;
        $this -> iz = $iz;
        $this -> husfajta = $husfajta;
        $this -> kiszereles = $kiszereles;
        $this -> eltarthatosag = $eltarthatosag;
        $this -> laktozmentes = $laktozmentes;
    }

    public function uj() {
        global $db;

        $db -> prepare('INSERT INTO adatok (marka, iz, husfajta, kiszereles, eltarthatosag, laktozmentes)
                        VALUES (:marka, :iz, :husfajta, :kiszereles, :eltarthatosag, :laktozmentes)')
            -> execute([
                
                ':marka' => $this -> marka,
                ':iz' => $this -> iz,
                ':husfajta' => $this -> husfajta,
                ':kiszereles' => $this -> kiszereles,
                ':eltarthatosag' => $this -> eltarthatosag -> format('Y-m-d H:i:s'),
                ':laktozmentes' => $this -> laktozmentes,
            ]);
    }

    public function getId() : ?int {
        return $this -> id;
    }
    public function getMarka() : string {
        return $this -> marka;
    }
    public function getIz() : string {
        return $this -> iz;
    }
    public function getHusfajta() : string {
        return $this -> husfajta;
    }
    public function getKiszereles() : int {
        return $this -> kiszereles;
    }
    public function getEltarthatosag() : DateTime {
        return $this -> eltarthatosag;
    }
    public function getLaktozmentes() : string {
        return $this -> laktozmentes;
    }

    public function getById(int $id) : Szalamik{
        global $db;
        $t = $db->query("SELECT * FROM adatok WHERE id = $id")
            ->fetchAll();
        
        $adat = new Szalamik($t[0]['marka'], $t[0]['iz'], $t[0]['husfajta'], $t[0]['kiszereles'], new DateTime($t[0]['eltarthatosag']), $t[0]['laktozmentes']);
        return $adat;
        
    }


    public function setMarka(string $ujMarka){
        $this -> marka = $ujMarka;
    }
    public function setIz(string $ujIz){
        $this -> iz = $ujIz;
    }
    public function setHusfajta(string $ujHusfajta){
        $this -> husfajta = $ujHusfajta;
    }
    public function setKiszereles(string $ujKiszereles){
        $this -> kiszereles = $ujKiszereles;
    }
    public function setEltarthatosag(string $ujEltarthatosag){
        $this -> eltarthatosag = $ujEltarthatosag;
    }
    public function setLaktozmentes(string $ujLaktozmentes){
        $this -> laktozmentes = $ujLaktozmentes;
    }
    
    public function mentes(string $id){
        global $db;

        $db->prepare('UPDATE adatok
                    SET marka = :marka, iz = :iz, husfajta = :husfajta, kiszereles = :kiszereles, eltarthatosag = :eltarthatosag, laktozmentes = :laktozmentes WHERE id = :id ')
            ->execute([
                
                ':marka' => $this -> marka,
                ':iz' => $this -> iz,
                ':husfajta' => $this -> husfajta,
                ':kiszereles' => $this -> kiszereles,
                ':eltarthatosag' => $this -> eltarthatosag,
                ':laktozmenes' => $this -> laktozmentes,
                ':id' => $id,
            ]);
    }
    
    public static function torol(int $id) {
        global $db;

        $db->prepare('DELETE FROM adatok WHERE id = :id')
            ->execute([':id' => $id]);
    }

    public static function osszes() : array {
        global $db;

        $t = $db->query("SELECT * FROM adatok ORDER BY id DESC")
            ->fetchAll();
        $eredmeny = [];

        foreach ($t as $elem) {
            $szalamik = new Szalamik($elem['marka'], $elem['iz'], $elem['husfajta'], $elem['kiszereles'], new DateTime($elem['eltarthatosag']), $elem['laktozmentes']);
            $szalamik ->id = $elem['id'];
            $eredmeny[] = $szalamik;
        }

        return $eredmeny;
    }
    
}

