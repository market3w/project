<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li <?php if($page=='index'){echo'class="active"';} ?>><a href="index.php"><i class="icon-dashboard"></i><span>Tableau de bord</span> </a> </li>
        <li <?php if($page=='rdv'){echo'class="active"';} ?>><a href="rdv.php"><i class="icon-calendar"></i><span>Rendez-vous</span> </a> </li>
       <li <?php if($page=='campagnes'){echo'class="active"';} ?>><a href="campagnes.php"><i class="icon-bar-chart"></i><span>Campagnes</span> </a> </li>
        <li <?php if($page=='documents'){echo'class="active"';} ?>><a href="documents.php"><i class="icon-list-alt"></i><span>Documents</span> </a> </li>
        <li <?php if($page=='factures'){echo'class="active"';} ?>><a href="factures.php"><i class="icon-credit-card"></i><span>Factures</span> </a> </li>
     <li <?php if($page=='contact'){echo'class="active"';} ?>><a href="contact.php"><i class="icon-envelope"></i><span>Contact</span> </a></li>
      
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->