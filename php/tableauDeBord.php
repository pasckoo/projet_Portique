<?php
require_once('modele.class.php');

$id_session = session_id();

// Affichage du tableau de bord



function tableauDeBord(){ 
    $db2 = new database();
    if(session_id() && ($_SESSION['type'] > 0)){$visible = "visible";}else{$visible = "hidden";};    
      
// affichage titre de la page 
 echo'<div class="row bg-light border border-dark"><h1>Tableau de bord</h1></div>
 <div class="row  p-3" id="rowServices"  ></div>';

 

// affichage des indicateurs

    echo'<div class="container">

                    <div class="row ">            
                            
                  
                         
                        <div class="col-md-3  text-center"> 
                            <div class="container-fluid d-flex ">
                                    
                                     <div class="indicRetards card h-100 w-100 pointer"   id="indicateurRetards">
                                         <div class="card-header text-light">Contrôles en retard</div>
                                         <div class="card-body text-center">
                                            <img src="../IMG/controle/retard1.png"/>';
                                            
                                            
                                            echo'<h5>'.$db2->totalRetardCount().'  contrôle(s) en retard</h5>    
                                         </div>
                                     </div>
                            </div>
                        </div>
                                       
                        <div class="col "> 
                            <div class="row">
                                <div class="container-fluid d-flex pointer">
                                    <div class="indic30Jours card h-100 w-100 pointer" id="indicateur30Jours">
                                        <div class="card-header text-light">Contrôles dans les 30 prochains jours
                                        </div>
                                        <div class="card-body text-center" style="height:110px">
                                            <img src="../IMG/controle/calendrier1.png"/>
                                            <p><h5>'.$db2->controle30joursCount().'  contrôle(s) à réaliser</h5></p>    
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="container-fluid d-flex  pointer">
                                    <div class="indicSansControle card h-100 w-100 pointer" id="indicateurSansControle"'.$visible.'>
                                        <div class="card-header text-light">Suivi des connexions
                                        </div>
                                            <div class="card-body text-center" style="height:110px">
                                                <img src="../IMG/connect.png"/>
                                                <p><h5>'.$db2->totalRowConnexionCount().'  connexion(s)</h5></p> 
                                            </div>
                                        </div>
                                    </div>        
                                </div>
                            </div> 
                                
                    
                                                                                      
                        <div class="col-sm-4 col-md-5 ">
                            <div class="card">
                                <div class="card-header text-light">Avancement des contrôles à réaliser
                                </div>
                                <div class="card-body" style="height: 350px">
                                    <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                    </div>
                                        <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                        
                                            <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0">
                                            </div>
                                        
                                        <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                            <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                        </div>
                                    </div> <canvas id="chart-line" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 199px; height: 200px;"></canvas>
                                </div>
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>    
                
                 

                

                
                
                <div class="page-content page-container" id="page-content">
                <div class="padding">
                    <div class="row">
                        <div class="container-fluid d-flex justify-content-center">
                            
                        </div>
                    </div>
                </div>

<script>
var retard = '.$db2->totalRetardCount().';
var mois = '.$db2->controle30joursCount().';
var reste = '.$db2->controleResteCount().';
var total_controles = retard + mois + reste;

    $(document).ready(function() {
        var ctx = $("#chart-line");
        var myLineChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: ["En retard", "30 prochains jours", "planifiés"],
                datasets: [{
                    data: [retard, mois, reste],
                    backgroundColor: ["rgba(255, 0, 0, 0.5)","rgba(255, 208, 0, 0.5)","rgba(100, 255, 0, 0.5)"],
                    borderColor: "transparent"
                }],
                
            },
            options: {
                cutoutPercentage: 80,
                maintainAspectRatio: false,
                title: {
                    display: true,
                    text: total_controles + " contôles programmés",
                   
                }
            }
        });
    });
</script>                  
            
            
    </div>';
                
//echo'<div class="row  p-4  " id="rowServices"></div>';



}

?>