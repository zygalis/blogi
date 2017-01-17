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

                            print '<div>';

                                while ($tietue = $kysely->fetch()) {
                                    print '<p>';
                                    print '<span><b>' . $tietue['otsikko'] . '</b> ' . date('d.m.Y H.i',strtotime($tietue['paivays'])) . ' by ' . $tietue['tunnus'] . '</span><br />';
                                    print "<a href='blogi.php?id=$tietue->id'>t</a>";
                                    print '<br><a href="poista.php?id=' . $tietue['id']. '" onclick="return confirm(\'Jatketaanko?\');"><span class="glyphicon glyphicon-trash"></span></a>';
                                    print '</p><hr>';
                                    }
                            print '</div>';
                        }   
                        catch (PDOException $pdoex){
                            print '<p>Häiriö tietokannassa.' . $pdoex->getMessage(). '</p>';
                        }?>
	</div>
    </div>
</div>
<?php include_once "inc/bottom.php";?>

