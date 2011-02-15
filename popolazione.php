<?php
# **************************************
#  Author: S. Vaccaro, sergiovaccaro67@gmail.com
#  Vers: 1.0
#  Created on: 29/9/2006
# **************************************

class popolazione {
      
      private $popClient;
      
      function __construct($wsdl) {
               $this->popClient= new SoapClient($wsdl);
               }
      
      public function getListaRegione($cerca) {
             if (empty($cerca)) {
                trigger_error('Parametri insufficienti',E_USER_WARNING);
                return false;
                } else {
                $risposta=$this->popClient->CodiceRegione($cerca);
                return $risposta;
                }
             }
      
      public function getListaProvincia($cerca) {
             if (empty($cerca)) {
                trigger_error('Parametri insufficienti',E_USER_WARNING);
                return false;
                } else {
                $risposta=$this->popClient->GetProvince($cerca);
                return $risposta;
                }
             }
      
      public function getListaComune($cerca) {
             if (empty($cerca)) {
                trigger_error('Parametri insufficienti',E_USER_WARNING);
                return false;
                } else {
                $risposta=$this->popClient->GetComuni($cerca);
                return $risposta;
                }
             }
      
      public function getDemo($codice) {
             if (empty($codice)) {
                /* $risposta=$this->popClient->GetPopolazioneItalia(); */
                $risposta=false;
                } elseif ($codice=='Italia') {
                $risposta=$this->popClient->GetPopolazioneItalia(200);
                } elseif (preg_match("/^\d{1,2}$/",$codice)) {
                $risposta=$this->popClient->GetPopolazioneRegione($codice);
                } elseif (preg_match("/^\d{3}$/",$codice)) {
                $risposta=$this->popClient->GetPopolazioneProvincia($codice);
                } elseif (preg_match("/^\d{6}$/",$codice)) {
                $risposta=$this->popClient->GetPopolazioneComune($codice);
                } else {
                trigger_error('Parametri non corretti',E_USER_WARNING);
                $risposta=false;
                }
             return $risposta;
             }
      
      }

?>