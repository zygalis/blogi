<?php 

include_once "inc/top.php";
?>

   
<br>
<div class="container aqua">
    <div class="row">
	<div class="col-sm-8 ">
		<fieldset>
                    <?php 
                    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
                        try {
                            $tietokanta = new PDO('mysql:host=localhost;dbname=blogi;charset=utf8','root','');
                
                            $tietokanta->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                            //  $sql = "SELECT * FROM kirjoitus WHERE kayttaja_id=1";
                            $sql = $tietokanta->prepare("SELECT *,kirjoitus.id as id FROM kirjoitus INNER JOIN kayttaja ON kirjoitus.kayttaja_id = kayttaja_id"
                                    . " ORDER BY paivays desc");
                
                            $kysely = $tietokanta->query($sql);
                            
                            

                            print '<div>';

                                while ($tietue = $kysely->fetch()) {
                                    print '<p><a href="index.php">Takaisin etusivulle</a>';
                                    print '<span><h3><b>' . $tietue['otsikko'] . '</h3></b> ' . date('d.m.Y H.i',strtotime($tietue['paivays'])) . ' by ' . $tietue['tunnus'] . '</span><br />';
                                    print $tietue['teksti'];
                                    print '<br><a href="poista.php?id=' . $tietue['id']. '" onclick="return confirm(\'Jatketaanko?\');"><span class="glyphicon glyphicon-trash"></span></a>';
                                    print '</p><hr>';
                                    }
                            print '</div>';
                        }   
                        catch (PDOException $pdoex){
                            print '<p>Häiriö tietokannassa.' . $pdoex->getMessage(). '</p>';
                        }?>
            <form id="lisaa_kommentti" method="post" action="<?php print($_SERVER['PHP_SELF']);?>">
                <input type="hidden" name="kirjoitus_id" value="<?php print $tietue->id;?>">
                <textarea name="teksti" id="teksti"></textarea>
            </form>
                    <?php
                    $kysely->bindValue(':kayttaja_id', $_SESSION);
                            
                    $kysely->execute();
                            
                    header("Location: blogi.php?id=$id");
                    exit;
                    ?>
	</div>
    </div>
</div>
<?php include_once "inc/bottom.php";?>
