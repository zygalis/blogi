<?php include_once "inc/top.php";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="container aqua">
            <div class="row">
		<div class="col-sm-8 ">
                    <h3></h3>
                    <?php
                        $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
        
                        try{
                            //Avataan tietokantayhteys
                            $tietokanta = new PDO('mysql:host=localhost;dbname=blogi;charset=utf8','root','');
                            // Oletuksen PDO ei näytä mahdollisia virheitä, joten asetetaan "virhekoodi" päälle.
                            $tietokanta->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                            //Muodostetaan parametroitu sql-kysely tiedon poistamista varten.
                            $kysely = $tietokanta->prepare("DELETE FROM kirjoitus WHERE id=:id");
            
                            $kysely->bindValue(':id',$id,PDO::PARAM_INT);
            
                            // Suoritetaan kysely ja tarkastetaan samalla mahdollinen virhe.
                            if ($kysely->execute()) {
                                print ('<p>Kirjoitus poistettu.</p>');
                            }
                            else {
                                print '<p>';
                                print_r($tietokanta->errorInfo());
                                print '</p>';
                            }
                            print ("<a href='index.php'>Takaisin etusivulle</a>");
                        } catch (PDOException $pdoex) {
                            print '<p>Tietokannan avaus epäonnistui.' . $pdoex->getMEssage(). '</p>';
                        }
        
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
<?php 
include_once "inc/bottom.php";
?>