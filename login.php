<?php
include_once 'inc/top.php';
$viesti = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $tietokanta = new PDO('mysql:host=localhost;dbname=blogi;charset=utf8','root','');
    $tietokanta->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    if ($tietokanta!=null){
        try {
            $tunnus = filter_input(INPUT_POST, 'tunnus', FILTER_SANITIZE_STRING);
            $salasana = md5(filter_input(INPUT_POST, 'salasana', FILTER_SANITIZE_STRING));
            
            $sql = "SELECT * FROM kayttaja where tunnus='$tunnus' AND salasana='$salasana'";
            
            $kysely = $tietokanta->query($sql);
            
            if($kysely->rowCount()===1) {
                $tietue = $kysely->fetch();
                $_SESSION['login'] = true;
                $_SESSION['kayttaja_id'] = $tietue['id'];
                header('Location: index.php');
            }
            else {
                $viesti = "Väärä tunnus tai salasana!";
            }
        } catch(PDOException $pdoex) {
            print "Käyttäjän tietojen hakeminen epäonnistui." . $pdoex->getMessage();
        }
    }
}
?>
<div class="container aqua">
    <div class="row">
        <div class="col-sm-8 ">
            <form class="form-horizontal" method="post" role="form">
                <fieldset>
                    <br><br>
                        <div class="form-group">
                            <label class="control-label col-sm-1">Tunnus:</label>
                                <div class="col-sm-12">
                                    <input id="tunnus" class="form-control" maxlength="30" name="tunnus" required="" type="text">
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-1">Salasana:</label>
                                <div class="col-sm-12">
                                    <input id="salasana" class="form-control" maxlength="30" name="salasana" required="" type="password">
                                </div>
                        </div>
                        <input class="btn btn-primary pull-left" type="submit" value="Tallenna">
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php 
include_once "inc/bottom.php";
?>