<?php 
  include "php/config.php";
  $new_url = "";
  if(isset($_GET)){
    foreach($_GET as $key=>$val){
      $u = mysqli_real_escape_string($conn, $key);
      $new_url = str_replace('/', '', $u);
    }
      $sql = mysqli_query($conn, "SELECT full_url FROM url WHERE shorten_url = '{$new_url}'");
      if(mysqli_num_rows($sql) > 0){
        $sql2 = mysqli_query($conn, "UPDATE url SET clicks = clicks + 1 WHERE shorten_url = '{$new_url}'");
        if($sql2){
            $full_url = mysqli_fetch_assoc($sql);
            header("Location:".$full_url['full_url']);
          }
      }
  }
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Link Kısaltma</title>
  <link rel="stylesheet" href="style.css">
  <!-- Iconsout Link for Icons -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
</head>
<body>
  <div class="wrapper">
    <form action="#" autocomplete="off">
      <input type="text" spellcheck="false" name="full_url" placeholder="Link" required>
      <i class="url-icon uil uil-link"></i>
      <button>Kısalt</button>
    </form>
    <?php
      $sql2 = mysqli_query($conn, "SELECT * FROM url ORDER BY id DESC");
      if(mysqli_num_rows($sql2) > 0){;
        ?>
          <div class="statistics">
            <?php
              $sql3 = mysqli_query($conn, "SELECT COUNT(*) FROM url");
              $res = mysqli_fetch_assoc($sql3);

              $sql4 = mysqli_query($conn, "SELECT clicks FROM url");
              $total = 0;
              while($count = mysqli_fetch_assoc($sql4)){
                $total = $count['clicks'] + $total;
              }
            ?>
            <span>Toplam Linkler: <span><?php echo end($res) ?></span> & Toplam Tıklamalar: <span><?php echo $total ?></span></span>
            <a href="php/delete.php?delete=all">Hepsini Sil</a>
        </div>
        <div class="urls-area">
          <div class="title">
            <li>Kısaltılmış Link ID</li>
            <li>Orjinal Link</li>
            <li>Tıklamalar</li>
            <li>Eylemler</li>
          </div>
          <?php
            while($row = mysqli_fetch_assoc($sql2)){
              ?>
                <div class="data">
                <li>
                  <a href="<?php echo $domain.$row['shorten_url'] ?>" target="_blank">
                  <?php
                    if($domain.strlen($row['shorten_url']) > 50){
                      echo $domain.substr($row['shorten_url'], 0, 50) . '...';
                    }else{
                      echo $domain.$row['shorten_url'];
                    }
                  ?>
                  </a>
                </li> 
                <li>
                  <?php
                    if(strlen($row['full_url']) > 60){
                      echo substr($row['full_url'], 0, 60) . '...';
                    }else{
                      echo $row['full_url'];
                    }
                  ?>
                </li> 
              </li>
                <li><?php echo $row['clicks'] ?></li>
                <li><a href="php/delete.php?id=<?php echo $row['shorten_url'] ?>">Sil</a></li>
              </div>
              <?php
            }
          ?>
      </div>
        <?php
      }
    ?>
  </div>

  <div class="blur-effect"></div>
  <div class="popup-box">
  <div class="info-box">Kısa linkiniz hazır.</div>
  <form action="#" autocomplete="off">
    <label>Kısa linki düzenle</label>
    <input type="text" class="shorten-url" spellcheck="false" required>
    <i class="copy-icon uil uil-copy-alt"></i>
    <button>Kaydet</button>
  </form>
  </div>

  <script src="script.js"></script>

</body>
</html>

