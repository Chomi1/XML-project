<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="style.css"> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="script.js"></script> 
  
    </head>
    <body>
        <header>
            <h1>PRIJAVA/REGISTRACIJA KORISNIKA</h1>            
        </header>
        <main>
            <div class="center">
                <div class="prijava">
                    <h3 class="naslovi">PRIJAVA</h3>
                    <form action="" method="POST">
                        <label class="labels" for="korisnickoImeLogin">Korisiničko ime:</label><br>
                        <input type="text" name="korisnickoImeLogin" id="korisnickoImeLogin" required><br>
                        <label class="labels" for="lozinkaLogin">Lozinka:</label><br>
                        <input type="password" name="lozinkaLogin" id="lozinkaLogin" required><br><br>
                        <div class="center"><input class="btn btn-primary" type="submit" name ="prijava" id="prijava" value="Prijava"></div>
                        <span id="porukaprijava"></span><br>              
                    </form>
                </div>
                <div class="registracija">
                    <h3 class="naslovi">REGISTRACIJA</h3>
                    <form action="" method="POST">
                        <label class="labels" for="ime">Korisničko ime:</label><br>
                        <input type="text" name="korisnickoIme" id="korisnickoIme" required><br>
                        <label class="labels" for="mail">E-mail:</label><br>
                        <input type="text" name="mail" id ="mail" required> <br>
                        <span id="porukaMail"></span>
                        <label class="labels" for="lozinka">Lozinka:</label><br>
                        <input type="password" name="lozinka" id="lozinka" required><br>
                        <label class="labels" for="lozinka1">Potvrdi lozinku:</label><br>
                        <input type="password" name="lozinka1" id="lozinka1" required><br>
                        <span id="porukalozinka"></span><br>
                        <div class="center"><input class="btn btn-primary" type="submit" id="registracija" name="registracija" value="Registracija"></div>                  
                    </form>
                </div>
            </div>
        </main>
        <script>

            document.getElementById("registracija").onclick = function(event){
                var slanje_forme = true;

                //validacija formata e-maila

                var poljemail = document.getElementById("mail");
                var mail = document.getElementById("mail").value;
                var mail_format = /^([A-Ža-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if(mail.match(mail_format)){
                    slanje_forme = true;
                }
                else{
                    document.getElementById("porukaMail").innerHTML = "Upišite ispravan format<br>";
                    poljemail.style.borderColor = "red";                                 
                    slanje_forme = false;
                }

                // Provjera lozinki
                var poljelozinka = document.getElementById("lozinka");
                var lozinka = document.getElementById("lozinka").value;
                var poljelozinka1 = document.getElementById("lozinka1");
                var lozinka1 = document.getElementById("lozinka1").value;

                if (lozinka != lozinka1) {
                    slanje_forme = false;
                    poljelozinka.style.borderColor = "red";
                    poljelozinka1.style.borderColor = "red";
                    document.getElementById("porukalozinka").innerHTML = "Lozinke moraju biti iste<br>";
                }


                if (slanje_forme != true) {
                    event.preventDefault();
                }
            }
        </script>
        <?php

            if(isset($_REQUEST['registracija'])){
                $xml= new DOMDocument("1.0", "UTF-8");
                $xml->load("xml/korisnici.xml");

                $rootTag = $xml->getElementsByTagName("korisnici")->item(0);
                $korisnik = $xml->createElement("korisnik");

                $korisnickoIme = $xml->createElement("korisnickoIme", $_REQUEST['korisnickoIme']);
                $lozinka = $xml->createElement("lozinka", $_REQUEST['lozinka']);

                $korisnik->appendChild($korisnickoIme);
                $korisnik->appendChild($lozinka);

                $rootTag->appendChild($korisnik);
                $xml->save("xml/korisnici.xml");
            }
        ?>
        <?php
            if(isset($_POST['prijava'])){
                $uname=$_POST["korisnickoImeLogin"];
                $pwd=$_POST["lozinkaLogin"];
                $xml=simplexml_load_file("xml/korisnici.xml") or die("Error: Cannot create object");
                foreach($xml->korisnik as $korisnik){ 
                        if($korisnik->korisnickoIme==$uname)
                        {
                            if($korisnik->lozinka==$pwd)
                            {
                             echo "<script>window.open('naslovna.html');</script>";
                            }
                            else
                            {
                                echo "<script>alert('Netočna lozinka. Pokušajte ponovo');</script>";
                                return;
                            }                    
                        }
                    }
                    echo "<script>alert('Korisničko ime ne postoji. Potrebna je registracija');</script>";
            }
        ?>

    </body>
</html>