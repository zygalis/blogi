<?php 
include_once "inc/top.php";
?>
<br>
<div class="container aqua">
    <div class="row">
	<div class="col-sm-8 ">
		<fieldset>
                    <?php 
                        try {
                            $tietokanta = new PDO('mysql:host=localhost;dbname=blogi;charset=utf8','root','');
                
                            $tietokanta->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                            //  $sql = "SELECT * FROM kirjoitus WHERE kayttaja_id=1";
                            $sql = "SELECT *,kirjoitus.id as id FROM kirjoitus INNER JOIN kayttaja ON kirjoitus.kayttaja_id = kayttaja_id"
                                    . " ORDER BY paivays desc";
                
                            $kysely = $tietokanta->query($sql);
                            $kysely->setFetchMode(PDO::FETCH_OBJ);

                                while($tietue = $kysely->fetch()) {
                                    print '<div>';
                                        print "<p>";
                                        print date("d.m.Y H.i",  strtotime($tietue->paivays)) . " by " . $tietue->tunnus . "<br/>";
                                        print "<b><a href='blogi.php?id=$tietue->id'>$tietue->otsikko</a></b>&nbsp;&nbsp;&nbsp;";
                                        if (isset($_SESSION['kayttaja_id'])) {
                                            print "<a href='poista.php?id=$tietue->id'><span class='glyphicon glyphicon-trash'></span></a>";     
                                        }
                                        print "</p>";     
                                    print "</div>";
                                }
                        }   
                        catch (PDOException $pdoex){
                            print '<p>Häiriö tietokannassa.' . $pdoex->getMessage(). '</p>';
                        }?>
	</div>
    </div>
</div>
<?php include_once "inc/bottom.php";?>

