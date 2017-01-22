<?php
include_once 'inc/top.php';

?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title></title>
    </head>
    <body>
        <?php
        
        $kayttaja_id = 1;
        
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $kayttaja_id = filter_input(INPUT_GET, 'kayttaja_id', FILTER_SANITIZE_NUMBER_INT);
        }
        else if ($_SERVER['REQUEST_METHOD']==='POST') {
            
            try {
                
                $tietokanta = new PDO('mysql:host=localhost;dbname=blogi;charset=utf8','root','');
               
                $tietokanta->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               
                $otsikko = filter_input(INPUT_POST, 'otsikko', FILTER_SANITIZE_STRING);
                $teksti = filter_input(INPUT_POST, 'teksti', FILTER_SANITIZE_STRING);
                
                $kysely = $tietokanta->prepare("INSERT INTO kirjoitus(kayttaja_id,otsikko,teksti) VALUES (:kayttaja_id,:otsikko,:teksti)");

                $kysely->bindValue(':kayttaja_id',$kayttaja_id,PDO::PARAM_INT);
                $kysely->bindValue(':otsikko',$otsikko,PDO::PARAM_STR);
                $kysely->bindValue(':teksti',$teksti,PDO::PARAM_STR);
                
                if ($kysely->execute()) {
                    header("location:index.php");
                }
                else {
                    print '<p>';
                    print_r($tietokanta->errorInfo());
                    print '</p>';
                }
                print ("<a href='index.php'>Etusivulle</a>");
               }
               
               catch (PDOException $pdoex) {
                   print '<p>Tietokannan avaus epäonnistui.' . $pdoex->getMessage(). '</p>';
               }
        }
        ?>

<div class="container aqua">
	<div class="row">
		<div class="col-sm-8 ">
			<form class="form-horizontal" method="post" role="form" action="tallenna.php">
				<fieldset>
				<h3>Lisää kirjoitus</h3>
				<div class="form-group">
					<label class="control-label col-sm-1">Otsikko:</label>
					<div class="col-sm-12">
                                            <input id="otsikko" class="form-control" maxlength="30" name="otsikko" placeholder="Otsikko tähän" required="" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-1">Teksti:</label>
					<div class="col-sm-12">
                                            <textarea id="teksti" class="form-control" maxlength="255" name="teksti" placeholder="Teksti tänne..." required="" type="text"></textarea>
					</div>
				</div>
                                <input class="btn btn-primary pull-left" type="submit" value="Tallenna">&nbsp;
                                <a href="index.php" class="btn btn-default">Peruuta</a>
				</fieldset>
			</form>
		</div>
	</div>
</div>
        <?php include_once "inc/bottom.php";?>
