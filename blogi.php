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
                            $sql = "SELECT *,kirjoitus.id as id FROM kirjoitus INNER JOIN kayttaja ON kirjoitus.kayttaja_id = kayttaja_id"
                                    . " WHERE kirjoitus.id = $id";
                             if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                 
                                $teksti=filter_input(INPUT_POST,'kommentti',FILTER_SANITIZE_STRING);
                                $kirjoitus_id=filter_input(INPUT_POST,'kirjoitus_id',FILTER_SANITIZE_NUMBER_INT);                    
                                
                                $kysely = $tietokanta->prepare("INSERT INTO kommentti (teksti,kirjoitus_id,kayttaja_id) VALUES (:teksti,:kirjoitus_id,:kayttaja_id)");                    
                    
                                $kysely->bindValue(':teksti', $teksti, PDO::PARAM_STR);
                                $kysely->bindValue(':kirjoitus_id', $kirjoitus_id, PDO::PARAM_INT);
                                $kysely->bindValue(':kayttaja_id', $_SESSION['kayttaja_id'], PDO::PARAM_INT);
                                $kysely->execute(); 
                    
                                header("Location: blogi.php?id=$kirjoitus_id");
                                exit;
                            }
                            $kysely = $tietokanta->query($sql);
                            $kysely->setFetchMode(PDO::FETCH_OBJ);
                            $tietue = $kysely->fetch();   
                            
                            print '<div>';
                                    print '<p><a href="index.php">Takaisin etusivulle</a><br>';
                                    print '<b><h3>' . $tietue->otsikko . '</h3></b>';
                                    print '<p>' . date("d.m.Y H.i",  strtotime($tietue->paivays)) . " by " . $tietue->tunnus . "</p>";
                                    print '<p>' . $tietue->teksti . '</p>';
                                    if (isset($_SESSION['kayttaja_id'])) {
                                        print '<a href="poista.php?id=' . $tietue->id . '" onclick="return confirm(\'Jatketaanko?\');"><span class="glyphicon glyphicon-trash"></a>';
                                    }
                                    print '</p>';
                            print '</div>';
                            
                            print "<b><p class='kommentti'>Kommentit</p></b>";
                            
                            $sql = "SELECT *,kommentti.id as id FROM kommentti INNER JOIN kayttaja ON kommentti.kayttaja_id=kayttaja.id WHERE kirjoitus_id = $id";
                            
                            $kysely2=$tietokanta->query($sql);  
                            $kysely2->setFetchMode(PDO::FETCH_OBJ);
                            if (isset($_SESSION['kayttaja_id'])) {
                            ?>
                        
                        <form id="lisaa_kommentti" method="post" action="<?php print($_SERVER['PHP_SELF']);?>">
                            <input type="hidden" name="kirjoitus_id" value="<?php print $tietue->id;?>">
                            <textarea name="kommentti" id="kommentti"></textarea>
                        </form>

                        <?php  
                        }
                        print "<ul>";
                        while($tietue2 = $kysely2->fetch()){
                            print "<li>";
                            print $tietue2->teksti . " " . date("d.m.Y H.i",  strtotime($tietue->paivays));
                            print " by $tietue2->tunnus" . '&nbsp;';
                            if (isset($_SESSION['kayttaja_id'])) {
                                print "<a href='poista_kommentti.php?id=$tietue2->id&kirjoitus_id=$id'><span class='glyphicon glyphicon-trash'></span></a>"; 
                            }
                            print "</li>";
                        }
                        print "</ul>";
                    }   
                    catch (PDOException $pdoex){
                        print '<p>Häiriö tietokannassa.' . $pdoex->getMessage(). '</p>';
                    }?>
            </fieldset>  
	</div>
    </div>
</div>
<?php include_once "inc/bottom.php";?>
