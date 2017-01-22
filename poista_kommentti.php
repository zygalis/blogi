<?php 
include_once 'inc/top.php';
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
        <?php
            $tietokanta = new PDO('mysql:host=localhost;dbname=blogi;charset=utf8','root','');
                
            $tietokanta->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $id = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);
            $kirjoitus_id = filter_input(INPUT_GET, 'kirjoitus_id',FILTER_SANITIZE_NUMBER_INT);
            
            try {
                
                $kysely = $tietokanta->prepare("DELETE FROM kommentti WHERE id=:id");
                $kysely->bindValue(':id', $id, PDO::PARAM_INT);
                $kysely->execute();                
      
                print "<br><p>Kommentti poistettu.</p>";
                print "<a href='blogi.php?id=$kirjoitus_id'>Takaisin kirjoitukseen</a>";

            } catch (PDOException $pdoex) {
                print "Kirjoitusten hakeminen epäonnistui." . $pdoex->getMessage();
            }
        ?>
        </div>
    </div>
</div>
<?php 
include_once 'inc/bottom.php';
?>
