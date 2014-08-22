<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li <?php if($page=='index'){echo'class="active"';} ?>><a href="index.php"><i class="icon-dashboard"></i><span>Tableau de bord</span> </a> </li>
        <li <?php if($page=='documents'){echo'class="active"';} ?>><a href="documents.php"><i class="icon-list-alt"></i><span>Documents</span> </a> </li>
        <li <?php if($page=='video_conference'){echo'class="active"';} ?>><a href="video_conference.php"><i class="icon-facetime-video"></i><span>Vidéo-conference</span> </a></li>
        <li <?php if($page=='campagnes'){echo'class="active"';} ?>><a href="campagnes.php"><i class="icon-bar-chart"></i><span>Campagnes</span> </a> </li>
       
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->