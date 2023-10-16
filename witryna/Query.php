<?php
include_once 'connect.php';
class DB {
    protected $db;
    function __construct($db) {
        $this-> db=$db;
    }

    function __destruct() {
        $db = null;
    }
}

class User extends DB {
    protected $id;
    protected $phone;
    protected $password;
    

    function __construct($db,$phone, $pass) {
        parent::__construct($db);
        $this -> phone =$phone;
        
        $this -> password =$pass;
        $this -> login();
    }

    function getId() {
        return $this -> id;
    }
    function login() {
        $stmt = $this ->db -> prepare('SELECT NumerKlienta, Imie, Nazwisko FROM klienci where Telefon= :phone and haslo= :password;');
        $stmt -> execute(['phone' => $this -> phone, 'password' => md5($this -> password)]);
        $result = $stmt -> fetchAll();
        if(!empty($result)) {
           $this -> id=$result[0]['NumerKlienta'];
            
        } else throw new Exception("blad logowania");
    }

    function getUser() {
        $stmt = $this -> db -> prepare('select Imie, Nazwisko, Ulica, Miasto, KodPocztowy, Kraj from klienci where NumerKlienta = :numer and haslo = :haslo');
        $stmt -> execute(['numer' => $this -> id,'haslo' => md5($this -> password)]);
        return $stmt -> fetchAll(PDO::FETCH_OBJ)[0];
    }

    function updateUser($imie,$nazwisko,$miasto,$ulica,$kod,$kraj) {
        $stmt = $this -> db -> prepare('UPDATE klienci SET 
        Imie=:imie,
        Nazwisko=:nazwisko,
        Miasto=:miasto,
        Ulica=:ulica,
        KodPocztowy=:kod,
        Kraj=:kraj
        WHERE NumerKlienta = :num');
        $stmt -> execute(['imie' => $imie,'nazwisko' => $nazwisko,'miasto' => $miasto,'ulica' => $ulica,'kod' => $kod,'kraj' => $kraj,
        'num' => $this -> id]);
        
    }
    static function addUser($db,$imie,$nazwisko,$phone,$password) {
        $stmt = $db -> prepare('SELECT NumerKlienta FROM klienci where Telefon= :phone');
        $stmt -> execute( [ 'phone' => $phone ]);
        $result = $stmt -> fetchAll();
        if(!empty($result)) throw new Exception("nie mozna dodac uzytkownika");
        $stmt = $db -> prepare('INSERT INTO klienci(Imie,Nazwisko,Telefon,haslo) VALUES(:imie, :nazwisko, :phone, :password)');
        $stmt -> execute(['imie' => $imie,'nazwisko' => $nazwisko,'phone' => $phone, 'password' => md5($password)]);
        return new User($db,$phone, $password);
    }

}

class Order extends User {

    function __construct($user) {
        parent::__construct($user-> db, $user -> phone, $user -> password);
    }

    
    function getOrders() {
        $stmt = $this -> db -> prepare('select NumerZamowienia,DataZamowienia from zamowienia where NumerKlienta = :numer');
        $stmt -> execute(["numer" => $this -> id]);
        return $stmt -> fetchAll(PDO::FETCH_OBJ);
    }
    function addOrder($zam,$idP,$il) {
        $stmt =  $this -> db -> prepare('INSERT INTO szczegoly_zamowien(NumerZamowienia, IdPudelka, Ilosc) 
        VALUES (:num, :idp, :il)');
        $stmt -> execute(['num' => $zam, 'idp'=> $idP, 'il' => $il]);
        $stmt -> fetchAll(PDO::FETCH_OBJ);
    }

    function getNextOrder() {
        $stmt = $this -> db -> prepare('select max(NumerZamowienia) as n from zamowienia');
        $stmt -> execute();
        $result = $stmt -> fetchAll(PDO::FETCH_OBJ);
        return ((int)$result[0]-> n)+1;
    }
    function insertOrder($imie,$nazwisko,$ulica,$miasto,$kod,$kraj) {
        $ordid=$this ->getNextOrder();
        $stmt = $this -> db -> prepare("INSERT INTO zamowienia(NumerZamowienia, NumerKlienta,  DataZamowienia,  NazwiskoOdbiorcy,
        ImieOdbiorcy, UlicaOdbiorcy, MiastoOdbiorcy, 
        KodPocztowyOdbiorcy, KrajOdbiorcy) VALUES (:numer, :nrklienta, :datazam, :nazwisko, :imie, :ulica, :miasto, :kod, :kraj)");
        $stmt -> execute(['numer'=> $ordid, 'nrklienta' => $this -> id, 'datazam'=> date("Y-m-d"), 'imie'=> $imie,
        'nazwisko'=> $nazwisko, 'ulica'=> $ulica, 'miasto'=> $miasto, 'kod'=> $kod, 'kraj'=> $kraj]);
        $result = $stmt -> fetchAll(PDO::FETCH_OBJ);
        return $ordid;
    }

}

class OrderDetails extends Order {
    protected $orderNumer;

    function __construct($user, $orderNumer) {
        parent::__construct($user);
        $this -> orderNumer = $orderNumer;
    }

    function getBoxes() {
        $stmt = $this -> db -> prepare('SELECT nazwapudelka,Cena, Ilosc,NumerKlienta 
        from szczegoly_zamowien INNER JOIN pudelka on pudelka.IdPudelka=szczegoly_zamowien.IdPudelka inner join zamowienia on zamowienia.NumerZamowienia=szczegoly_zamowien.NumerZamowienia  
        WHERE szczegoly_zamowien.NumerZamowienia=:num and NumerKlienta = :id;');
        $stmt -> execute(['num' => $this -> orderNumer,'id' => $this -> id]);
        return $stmt -> fetchAll(PDO::FETCH_OBJ);
    }

    function insertOrderDetail($numerek,$boxid,$quantity) {
        $stmt = $this -> db -> prepare('INSERT INTO szczegoly_zamowien(NumerZamowienia, IdPudelka, Ilosc) 
        VALUES (:num, :idp, :il)');
        $stmt -> execute(['num' => $numerek, 'idp'=> $boxid, 'il' => $quantity]);
        $result = $stmt -> fetchAll(PDO::FETCH_OBJ);
    }
    function getData() {
        $stmt = $this -> db -> prepare('select ImieOdbiorcy,NazwiskoOdbiorcy,DataZamowienia,MiastoOdbiorcy from zamowienia where NumerZamowienia = :num and NumerKlienta= :klienum');
        $stmt -> execute(["klienum" => $this -> id,"num" => $this -> orderNumer]);
        return $stmt -> fetchAll(PDO::FETCH_OBJ)[0];
    }

}

class Pudelko extends DB {
    function __construct($db) {
        parent::__construct($db);  
    }

    function getBoxes($lista) {
        $ids = "('".implode("','",unserialize($lista))."')";
        $stmt = $this -> db -> prepare('select idPudelka, NazwaPudelka, Cena,url from pudelka where idPudelka in '.$ids);
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_OBJ);
    }
    function getBox($id) {
        $stmt = $this -> db -> prepare('select idPudelka, NazwaPudelka, Cena, Opis,url from pudelka where idPudelka = :id');
        $stmt -> execute(['id' => $id]);
        return $stmt -> fetchAll(PDO::FETCH_OBJ);
    }
    function getAllBoxes() {
        $stmt = $this -> db -> prepare('select idPudelka, NazwaPudelka, Cena,url from pudelka');
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_OBJ);
    }
}
