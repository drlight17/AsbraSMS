<?php /*

    AsbraSMS v1.0 is a frontend for smstools
    Copyright (C) 2019 Nimpen J. Nordström <j@asbra.nu>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation version 3.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.

*/
$phone   = $_GET['phone'] ?? '';
$message = $_GET['message'] ?? '';
$date    = date("ymd_His");
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <?php
        //header('Content-Type: text/html; charset=windows-1251')
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <style>
      .bg-black { background-color:#000; }
      a { font-weight:bold; }
    </style>

    <title>AsbraSMS</title>
  </head>

  <nav class="navbar navbar-dark bg-dark mb-5">
    <div class='container'>
      <a class="navbar-brand" href="<?php echo $_SERVER['PHP_SELF']; ?>">Asbra<b class='text-primary'>SMS</b></a>
      <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link active" href="https://xn--1ca.se">Author</a>
          <a class="nav-item nav-link active" href="<?php echo $_SERVER['PHP_SELF']; ?>">Home <span class="sr-only">(current)</span></a>
        </div>
      </div>
    </div>
  </nav>

  <body class='bg-black text-light'>

    <div class='container'>

      <div class='row mb-4'>
        <div class='col-lg-6 mb-3'>

          <div class='card card-body bg-dark text-light'>
            <h3 class='mb-3'>Compose your message</h3>
            <form method=get>
              <div class="form-group">
                <label for="inputPhone">Mobile Phone Number</label>
                <input name="phone" value="<?=$phone?>" type="text" class="form-control" id="inputPhone" aria-describedby="phoneHelp" placeholder="Phone number">
                <small id="phoneHelp" class="form-text text-muted">Dont forget country code (+46)</small>
              </div>
              <div class="form-group">
                <label for="inputSms">SMS Message</label>
                <input name="message" value="<?=$message?>" type="text" class="form-control" id="inputSms" placeholder="SMS Message">
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>

        </div>
        <div class='col-lg-6 mb-3'>

          <?php if ( ! empty ( $phone ) && ! empty ( $message ) ) : ?>
              <div class='card card-body bg-warning text-light mb-4'>
              <h3>Sending...</h3>
                <?php
                    $content="To: $phone\n\n$message"; ?>
                <pre><?=$content?></pre>
                <?php // convert message to SMS for cyrillic support
                    $content=iconv("utf-8","windows-1251", $content); ?>
                <?php file_put_contents("smsd/outgoing/$date.txt", $content); ?>

              </div>
          <?php endif; ?>
        </div>
      </div> <!-- /row -->

      <div class='row'>

        <div class='col-lg-6 mb-3'>
          <div class='card card-body bg-dark text-light'>
          <h4>Sent</h4>
            <?php globber("smsd/sent/*"); ?>
          </div>
        </div>

        <div class='col-lg-6 mb-3'>
          <div class='card card-body bg-dark text-light'>
          <h4>incoming</h4>
            <?php globber("smsd/incoming/*"); ?>
          </div>
        </div>

<?php if ( ! empty ( glob ( "smsd/failed/*"  ) ) ) : ?>
        <div class='col-lg-12 mb-3'>
          <div class='card card-body bg-danger text-light'>
          <h4>Failed</h4>
            <?php globber("smsd/failed/*"); ?>
          </div>
        </div>
<?php endif; ?>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </body>
<footer class='text-center py-5'>
  <small>
    <strong>AsbraSMS Copyright © 2019 ASBRA AB, <j@asbra.nu></strong><br>
    <hr style="border-top:1px solid #fff; max-width:250px;">
    This is free software, and you are welcome to redistribute it
    under certain conditions.<br>
    See <a href='https://www.gnu.org/licenses/gpl-3.0.en.html'>GNU GPL v3</a> for more information.
  </small>
</footer>
</html>

<?php

function globber($path) {

  $files = glob($path);
  $dir = dirname($path);

  usort($files, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));

  echo "<table class='table table-striped table-dark table-sm'>";
  foreach ( $files as $file )
  {
    $filename = basename ( $file );
    echo "<tr><td><a href='$dir/$filename'>$filename</a></td><td><div class='float-right'>".date("Y-m-d H:i:s", filectime($file))."</div></td></tr>";
  }
  echo "</table>";

}
?>
