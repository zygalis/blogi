
<?php include_once 'inc/top.php';?>
<?php
$id=0;
?>
<div class="container">
   <div class="row">
       <div class="col-xs-12">
       <?php
       if ($_SERVER['REQUEST_METHOD']=="GET") {
            $id=filter_input(INPUT_GET, "id",FILTER_SANITIZE_NUMBER_INT);
            
            $sql='SELECT * FROM kirjoitus WHERE id=' . $id;
            $kysely=$tietokanta->query($sql);  
           $kysely->setFetchMode(PDO::FETCH_OBJ);
           if ($kysely->rowCount()==1) {
                 $tietue = $kysely->fetch();
                 $otsikko=$tietue->otsikko;
                 print "<h3>$otsikko</h3>";
           }
            else {
                print "<p>Kirjoitusta ei löydy, tietoja ei voi enää muuttaa!</p>";
           }
            
            
        }
        else if ($_SERVER['REQUEST_METHOD']=="POST") {       
            if ($tietokanta!=null) {
                try {
                   $id=filter_input(INPUT_POST,'kirjoitus_id',FILTER_SANITIZE_NUMBER_INT); 
                   $teksti=filter_input(INPUT_POST,'teksti',FILTER_SANITIZE_STRING);

                    $kysely = $tietokanta->prepare("INSERT INTO kommentti (teksti,kirjoitus_id) "
                        . "VALUES (:teksti,:kirjoitus_id)");

                    $kysely->bindValue(':teksti', $teksti, PDO::PARAM_STR);
                    $kysely->bindValue(':kirjoitus_id', $id, PDO::PARAM_INT);
               
                    $kysely->execute(); 
                    
                    print "<div class='col-xs-12'>";                    
                print "<p>Tiedot tallennettu.</p>";
                   print "<a href='index.php'>Takaisin etusivulle</a></div>";
               } catch (PDOException $pdoex) {
                    print "Kommentin tallentaminen epäonnistui." . $pdoex->getMessage();
                }
            }
        }
        ?>  
            <form role="form" method="post">
               <input name="kirjoitus_id" type="hidden" value="<?php print($id);?>">
               <div class="form-group">
                    <label for="teksti">Kirjoita kommentti</label>
                    <textarea class="form-control" id="teksti" name="teksti" required placeholder="Teksti tänne..."></textarea>
                </div>
                <div class="form-inline">
                    <button type="submit" class="btn btn-primary">Tallenna</button>
                    <a href="index.php" class="btn btn-default">Peruuta</a>
                </div>
            </form>  
        </div>
    </div>
</div>
<?php include_once 'inc/bottom.php';?>