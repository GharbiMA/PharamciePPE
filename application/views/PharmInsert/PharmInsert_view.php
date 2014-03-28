<?php
form_open('addPharma');
?>
<center><h2> Ajouter Pharmacie </h2></center>
<h3>Nom</h3><input name="nom" type="text">
<br>
<h3>Telephone</h3><input name="tel" type="text">
<br>
<h3>Type</h3><input name="type" type="text">
<?php echo form_submit('submit', 'Submit'); echo form_close(); ?>

