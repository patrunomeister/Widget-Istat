<?php
# **************************************
#  Author: Vincenzo Patruno, patrunomeister@gmail.com
#  Vers: 1.0
# **************************************

$title='Bilancio demografico e popolazione residente';

$righe=array();

require 'popolazione.php';

$DEBUG='';








# funzione che stampa i dati demografici
function buildDemo(&$title,&$righe,$codice,&$DEBUG) {
         
         $wsdl='http://demo.istat.it/mobile/getpopdir.php?wsdl';
         $pop = new popolazione($wsdl);
         if ($dati=$pop->getDemo($codice)) {
         		
             	//$datititolo=get_object_vars(array_pop($dati));
             	
             if (!empty($dati[2]->Comune)) {
                $title='Municipality of '.$dati[2]->Comune;
                //unset($dati[0]->Comune);
                } elseif (!empty($dati[2]->Provincia)) {
                $title='Province  '.$dati[2]->Provincia;
                //unset($dati[0]->Provincia);
                } elseif (!empty($dati[2]->Regione)) {
                $title='Region  '.$dati[2]->Regione;
                //unset($dati[0]->Regione);
                } else {
                $title='Italy';
                }
                
                $title= $title;
                //print_r($dati);
                
?>
    <script type='text/javascript' src='http://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['table']});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string','');
        data.addColumn('number', '<?echo $dati[2]->Periodo?>');
        data.addColumn('number', '<?echo $dati[0]->Periodo?>');
        data.addRows(6);
        data.setCell(0, 0, 'Population');
        data.setCell(0, 1, <?echo $dati[2]->Totale__al__31__Dic?>);
        data.setCell(0, 2, <?echo $dati[0]->Totale__al__31__Dic?>);
        data.setCell(1, 0, 'Males');
        data.setCell(1, 1, <?echo $dati[2]->Maschi?>);
        data.setCell(1, 2, <?echo $dati[0]->Maschi?>);
        data.setCell(2, 0, 'Females');
        data.setCell(2, 1, <?echo $dati[2]->Femmine?>);
        data.setCell(2, 2, <?echo $dati[0]->Femmine?>);
        data.setCell(3, 0, 'Live births');
        data.setCell(3, 1, <?echo $dati[2]->Nati?>);
        data.setCell(3, 2, <?echo $dati[0]->Nati?>);
        data.setCell(4, 0, 'Deaths');
        data.setCell(4, 1, <?echo $dati[2]->Morti?>);
        data.setCell(4, 2, <?echo $dati[0]->Morti?>);
        data.setCell(5, 0, 'Net migration');
        data.setCell(5, 1, <?echo $dati[2]->Saldo__Migratorio?>);
        data.setCell(5, 2, <?echo $dati[0]->Saldo__Migratorio?>);
        

       var table = new google.visualization.Table(document.getElementById('table_div'));
       table.draw(data, {showRowNumber: false});
      }
    </script>


<div id='comune'><font size="3" face="Arial"><?echo $title?></font></div>
    <div id='table_div'></div>
<div id='fonte'><font size="1" face="Arial"><i>Source: ISTAT</i></font></div>
                
 <?               
                
                
         		 
            	
            
             return true;
             } else {
             $righe[]='Codice='.$codice.': codice non valido!';
             return false;
             }
         }




if (!empty($_GET['codice'])) {

   buildDemo($title,$righe,$_GET['codice'],$DEBUG);
   
   }

   
   
   if (!empty($righe)) {
   $grigio=true;
   echo $title;
   foreach ($righe as $riga) {
           if ($riga=='Regioni:' || $riga=='Province:' || $riga=='Comuni:') {
              echo '<div><br /></div>'."\n";
              $grigio=true;
              }
           echo '<div';
           echo $grigio?' class="grigio"':'';
           echo '>'.$riga.'</div>'."\n";
           $grigio=!$grigio;
           }
   }
?>