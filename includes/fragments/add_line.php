<?php 
 
    $lista = array ("Redni broj stanice","Ime stanice","Sat polaska sa stanice","Minut polaska sa stanice","Rastojanje od polazne stanice");
    //button reactions
    if ($_POST['delete'] ?? '') {
      $x = $_POST['delete'];
      --$x;
      
      $get = $_SESSION['post_data'];
      
      $nova = json_decode($get);
          
          
      $nova= ukloniStanicu($nova, $x);
      if($nova!=NULL)
      for ($i=0; $i<count($nova);$i++){
        $nova[$i][0]=$i+1;
      }
     
      $set = json_encode($nova);
      if($set!="[]" || $set!=NULL)$_SESSION['post_data'] = $set;
      else $_SESSION['post_data'] = "";
      header("Refresh:0");
     
    }
    elseif ($_POST['erase']) {
      $_SESSION['post_data'] = "";
      header("Refresh:0");
     
    }
    //
    $provera = $_SESSION['post_data'];

    if($provera!="" && $provera!=NULL): 
      $matrica = json_decode($provera,$assoc = true);
      if($matrica!=NULL)
      for ($i=0; $i<count($matrica);$i++){
        $matrica[$i][0]=$i+1;
      }
      
      if($provera!="[]") {
?>

<fieldset class="fieldset">
  <form method="post" action="">
    <table id="redVoznjeDodaj">
      <thead class="dummy">
        <tr class="officers-table">
          <th><?php echo implode('</th><th>', $lista); ?></th>
      </tr> <?php } ?>
      </thead>
    <tbody class="dummy">  
<?php if($matrica!=NULL) { foreach ($matrica as $key=>$row): array_map('htmlentities', $row); ?>
      <tr class="officers-table">
        <td><?php echo implode('</td><td>', $row); ?></td>
        <td><button type="submit" class="delete" name="delete" value="<?php echo $row[0]; ?>">Ukloni</button></td>
      </tr>
<?php endforeach; }
  if($provera!="[]") {
?>
      <tr>   <td colspan="6">
          <div id="buttonWrapper">
          <button type="submit" class="formButtons" name="send" value="Potvrdi">Potvrdi</button>
          <button type="submit" class="formButtons" name="erase" value="Obriši sve">Obriši sve</button></div>
      </td>
</tr> <?php }?>
  </tbody>
  </table>
  
</fieldset>
</form>
<?php endif; 




?>