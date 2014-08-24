<?php  $page='index';  ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Espace membre | Market 3W</title>

<link href="css/pages/dashboard.css" rel="stylesheet">
<?php include('include/head.php');
 include('include/header.php');
  include('include/menu.php'); ?>

<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span6">
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-user"></i>
              <h3> Informations personnelles </h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <h6 class="bigstats" style="margin-bottom:0px;">
                 <div style="float:left;"> Nom : Culelesmouches<br/>
                  Prénom : Jean<br/>
                  Email : jeancule@lesmouches.com<br/>
                  Adresse : 1 rue de ton cou<br/>
                  Complément adresse : au fond à droite<br/>
                  Ville : Vince city<br/>
                  Code postal : 12345<br/>
                  Téléphone : <i>non renseigné</i><br/>
                  Mobile : 0601020304<br/>
                  Poste occupé : Cultivateur de mouche
                  </div>
                  <div style="float:right;text-align:right;">Nom entreprise<br/>
                  40 employés
                  </div>
                  <div style="clear:both;"></div>
                <a href="profil.php?aff=info_perso" style="color:#ffffff;text-decoration:none;"><button class="btn btn-info" style="float:right;">Modifier</button></a>
                  </h6>
                 
                </div>
                <!-- /widget-content --> 
                
              </div>
            </div>
          </div>
          <!-- /widget -->
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3>Agenda</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div id='calendar'>
              </div>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
          <div class="widget">
            <div class="widget-header"> <i class="icon-file"></i>
              <h3> Derniers documents</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <ul class="messages_layout">
                <li class="from_user left"> <a href="#" class="avatar"><img src="img/message_avatar1.png"/></a>
                  <div class="message_wrap"> <span class="arrow"></span>
                    <div class="info"> <a class="name">Nom Prénom</a> <span class="time">il y a 1 jour</span>
                      <div class="options_arrow">
                        <div class="dropdown pull-right"> <a class="dropdown-toggle " id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#"> <i class=" icon-caret-down"></i> </a>
                          <ul class="dropdown-menu " role="menu" aria-labelledby="dLabel">
                            <li><a href="#"><i class=" icon-share icon-large"></i> Télécharger</a></li>
                            <li><a href="#"><i class=" icon-share-alt icon-large"></i> Modifier</a></li>
                            <li><a href="#"><i class=" icon-trash icon-large"></i> Supprimer</a></li>
                            
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="text">Ici description du document téléchargé en mettant ce qu'il y a dedans bla blal bla. </div>
                  </div>
                </li>
                <li class="by_myself right"> <a href="#" class="avatar"><img src="img/message_avatar2.png"/></a>
                  <div class="message_wrap"> <span class="arrow"></span>
                    <div class="info"> <a class="name">Pauline che pas quoi </a> <span class="time">il y a 7 jours</span>
                      <div class="options_arrow">
                        <div class="dropdown pull-right"> <a class="dropdown-toggle " id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#"> <i class=" icon-caret-down"></i> </a>
                          <ul class="dropdown-menu " role="menu" aria-labelledby="dLabel">
                            <li><a href="#"><i class=" icon-share icon-large"></i> Télécharger</a></li>
                            <li><a href="#"><i class=" icon-share-alt icon-large"></i> Modifier</a></li>
                            <li><a href="#"><i class=" icon-trash icon-large"></i> Supprimer</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="text"> Ici description du document téléchargé en mettant ce qu'il y a dedans bla blal bla.  </div>
                  </div>
                </li>
                <li class="from_user left"> <a href="#" class="avatar"><img src="img/message_avatar1.png"/></a>
                  <div class="message_wrap"> <span class="arrow"></span>
                    <div class="info"> <a class="name">Nom Prénom</a> <span class="time">il y a 1 jour</span>
                      <div class="options_arrow">
                        <div class="dropdown pull-right"> <a class="dropdown-toggle " id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#"> <i class=" icon-caret-down"></i> </a>
                          <ul class="dropdown-menu " role="menu" aria-labelledby="dLabel">
                            <li><a href="#"><i class=" icon-share icon-large"></i> Télécharger</a></li>
                            <li><a href="#"><i class=" icon-share-alt icon-large"></i> Modifier</a></li>
                            <li><a href="#"><i class=" icon-trash icon-large"></i> Supprimer</a></li>
                            
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="text">Ici description du document téléchargé en mettant ce qu'il y a dedans bla blal bla. </div>
                  </div>
                </li>
                <li class="by_myself right"> <a href="#" class="avatar"><img src="img/message_avatar2.png"/></a>
                  <div class="message_wrap"> <span class="arrow"></span>
                    <div class="info"> <a class="name">Pauline che pas quoi </a> <span class="time">il y a 7 jours</span>
                      <div class="options_arrow">
                        <div class="dropdown pull-right"> <a class="dropdown-toggle " id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#"> <i class=" icon-caret-down"></i> </a>
                          <ul class="dropdown-menu " role="menu" aria-labelledby="dLabel">
                            <li><a href="#"><i class=" icon-share icon-large"></i> Télécharger</a></li>
                            <li><a href="#"><i class=" icon-share-alt icon-large"></i> Modifier</a></li>
                            <li><a href="#"><i class=" icon-trash icon-large"></i> Supprimer</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="text"> Ici description du document téléchargé en mettant ce qu'il y a dedans bla blal bla.  </div>
                  </div>
                </li>
                <li class="by_myself right"> <a href="#" class="avatar"><img src="img/message_avatar2.png"/></a>
                  <div class="message_wrap"> <span class="arrow"></span>
                    <div class="info"> <a class="name">Pauline che pas quoi </a> <span class="time">il y a 7 jours</span>
                      <div class="options_arrow">
                        <div class="dropdown pull-right"> <a class="dropdown-toggle " id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#"> <i class=" icon-caret-down"></i> </a>
                          <ul class="dropdown-menu " role="menu" aria-labelledby="dLabel">
                            <li><a href="#"><i class=" icon-share icon-large"></i> Télécharger</a></li>
                            <li><a href="#"><i class=" icon-share-alt icon-large"></i> Modifier</a></li>
                            <li><a href="#"><i class=" icon-trash icon-large"></i> Supprimer</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="text"> Ici description du document téléchargé en mettant ce qu'il y a dedans bla blal bla.  </div>
                  </div>
                </li>
               <center><a href="profil.php?aff=document" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info">Télécharger un document</button></a>
               <a href="documents.php" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info">Voir tous les documents</button></a></center>
              </ul>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget --> 
        </div>
        <!-- /span6 -->
        <div class="span6">
          
          
          
          
          <!-- /widget --> 
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3>Dernières campagnes</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <ul class="news-items">
                <li  style="width:auto;">
                  
                    <div class="news-item-detail"> <a href="campagne.php" class="news-item-title" target="_blank">Intitulé de la campagne</a>
                    <p class="news-item-preview">Ici petite description date ce que tu veux mmon grand eze f r f zr f r er  fe r f er tg tr  gr r g rt</p>
                      <div style="text-align:center;margin-top:10px;"><a href="campagne.php" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info">Voir la campagne</button></a></div>
           
                  </div>
                  
                </li>
                 <li  style="width:auto;">
                  
                     <div class="news-item-detail"> <a href="campagne.php" class="news-item-title" target="_blank">Intitulé de la campagne</a>
                    <p class="news-item-preview">Ici petite description date ce que tu veux mmon grand eze f r f zr f r er  fe r f er tg tr  gr r g rt</p>
                      <div style="text-align:center;margin-top:10px;"><a href="campagne.php" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info">Voir la campagne</button></a></div>
                  </div>
                  
                </li>
                 <li  style="width:auto;">
                  
                    <div class="news-item-detail"> <a href="campagne.php" class="news-item-title" target="_blank">Intitulé de la campagne</a>
                    <p class="news-item-preview">Ici petite description date ce que tu veux mmon grand eze f r f zr f r er  fe r f er tg tr  gr r g rt</p>
                      <div style="text-align:center;margin-top:10px;"><a href="campagne.php" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info">Voir la campagne</button></a></div>
           
                  </div>
                  
                </li>
                 <div style="text-align:center;margin-top:20px;margin-bottom:20px;"><a href="campagnes.php" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info">Voir toutes les campagnes</button></a></div>
           
              </ul>
            </div>
            <!-- /widget-content --> 
          </div>
          
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3>Dernières factures</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <ul class="news-items">
                <li  style="width:auto;">
                  
                    <div class="news-item-detail"> <a href="#" class="news-item-title" target="_blank">Facture n°12454434</a>
                    <p class="news-item-preview">Ici petite description date ce que tu veux mmon grand eze f r f zr f r er  fe r f er tg tr  gr r g rt</p>
                      <div style="text-align:center;margin-top:10px;"><a href="#" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info">Voir la facture</button></a></div>
           
                  </div>
                  
                </li>
                 <li  style="width:auto;">
                  
                     <div class="news-item-detail"> <a href="#" class="news-item-title" target="_blank">Facture n°12454434</a>
                    <p class="news-item-preview">Ici petite description date ce que tu veux mmon grand test etet tetet ttet tetet tt tet t</p>
                      <div style="text-align:center;margin-top:10px;"><a href="#" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info">Voir la facture</button></a></div>
           
                  </div>
                  
                </li>
                 <li  style="width:auto;">
                  
                    <div class="news-item-detail"> <a href="#" class="news-item-title" target="_blank">Facture n°12454434</a>
                    <p class="news-item-preview">Ici petite description date ce que tu veux mmon grandhh fhshsf fsfj dsfdjsdjkfsj jjjjjjj  jjjjj</p>
                      <div style="text-align:center;margin-top:10px;"><a href="#" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info">Voir la facture</button></a></div>
           
                  </div>
                  
                </li>
                 <div style="text-align:center;margin-top:20px;margin-bottom:20px;"><a href="#" style="color:#ffffff; text-decoration:none;"><button class="btn btn-info">Voir toutes les factures</button></a></div>
           
              </ul>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
        </div>
        <!-- /span6 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>
<!-- /main -->
<?php include('include/footer.php'); ?>
<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="js/jquery-1.7.2.min.js"></script> 
<script src="js/excanvas.min.js"></script> 
<script src="js/chart.min.js" type="text/javascript"></script> 
<script src="js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.js"></script>
 
<script src="js/base.js"></script> 
<script>     

      

        $(document).ready(function() {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var calendar = $('#calendar').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          selectable: true,
          selectHelper: true,
          select: function(start, end, allDay) {
            var title = prompt('Event Title:');
            if (title) {
              calendar.fullCalendar('renderEvent',
                {
                  title: title,
                  start: start,
                  end: end,
                  allDay: allDay
                },
                true // make the event "stick"
              );
            }
            calendar.fullCalendar('unselect');
          },
          editable: true,
          events: [
            {
              title: 'All Day Event',
              start: new Date(y, m, 1)
            },
            {
              title: 'Long Event',
              start: new Date(y, m, d+5),
              end: new Date(y, m, d+7)
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: new Date(y, m, d-3, 16, 0),
              allDay: false
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: new Date(y, m, d+4, 16, 0),
              allDay: false
            },
            {
              title: 'Meeting',
              start: new Date(y, m, d, 10, 30),
              allDay: false
            },
            {
              title: 'Lunch',
              start: new Date(y, m, d, 12, 0),
              end: new Date(y, m, d, 14, 0),
              allDay: false
            },
            {
              title: 'Birthday Party',
              start: new Date(y, m, d+1, 19, 0),
              end: new Date(y, m, d+1, 22, 30),
              allDay: false
            },
            {
              title: 'EGrappler.com',
              start: new Date(y, m, 28),
              end: new Date(y, m, 29),
              url: 'http://EGrappler.com/'
            }
          ]
        });
      });
    </script><!-- /Calendar -->
</body>
</html>
