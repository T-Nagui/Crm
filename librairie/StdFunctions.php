<?

class StdFunctions {

     
    public function AfficheDateFr($dateTime){
        $Date=  explode(' ', $dateTime);
        $DateD=  explode('-', $Date['0']);
        // inversser la date à afficher :p 
        $DateRetour=$DateD['2'].'/'.$DateD['1'].'/'.$DateD['0'];
        return $DateRetour.' '.$Date['1'];
    }
    public function SetDate($dateTime){
        $Date=  explode(' ', $dateTime);
        $DateD=  explode('/', $Date['0']);
        $DateSys=$DateD['2'].'-'.$DateD['1'].'-'.$DateD['0'];
        return $DateSys.' '.$Date['1'];
    }
 
  
    public function Comparedate($date){
         $dEnd = new DateTime($date);
   $dStart  = new DateTime('2014-10-24 00:00');
   $dDiff = $dStart->diff($dEnd);
   $j= $dDiff->format('%R%a'); // use for point out relation: smaller/greater
  // echo $j=$dDiff->days;
    if($j>30){
        return array('class'=>'success',
            'nbr'=>$j
        ) ;
    }elseif ($j<30 && $j>0) {
         
           return array(
            'class'=>'warning',
            'nbr'=>$j
        ) ;
        }else{
           return array(
            'class'=>'danger',
            'nbr'=>$j
        ) ;
        }
    }
     function getGenInfo($id,$table,$Cand,$var){
        global $PDO;
        $strSQL="SELECT $var FROM $table WHERE  $Cand= ?";
        $query = $PDO->prepare($strSQL);
			$query->execute(array($id));
			$retour = $query->fetch();
                        return $retour->$var;
    }
 
 
 
   
    /*CRM FUNCTIONS*/
    /*
     * function to get spec text and changed by id
     */
    function getSpec($id,$text){
if(!is_numeric($text)){//c pas un id
    $idSpec=$this->testChaine($text,'specialite');
    update($id,array('spec'=>$idSpec),'prospect');
}
    }
    function getAct($id,$text){
if(!is_numeric($text)){//c pas un id
    $idactivite=$this->testChaine($text,'activite');
    update($id,array('activite'=>$idactivite),'prospect');
}
    }
    function getPotentiel($id,$text){
if(!is_numeric($text)){//c pas un id
    $Recherche=get("*",'potentiel',array(
            'valeur='=>$text
        ));
    if($Recherche['total']>0){
        $Pot=$Recherche['reponse'][0]['id'];
    }else{
        $Pot="";
    }
    update($id,array('potentiel'=>$Pot),'prospect');
}
    }
    /*
     * function to get spec text and changed by id
     */
    function getGov($id,$text){
if(!is_numeric($text)){//c pas un id
    $idgouvernorat=$this->testChaine($text,'gouvernerat');
    update($id,array('gouvernorat'=>$idgouvernorat),'prospect');
}
    }
    function getDelg($id,$idg,$text){
        if(!is_numeric($text)&& is_numeric($idg)){//c pas un id
            $idDelg=$this->testChaine($text,'delegation',$idg);
            update($id,array('delegation'=>$idDelg),'prospect');
        }
    }
     
    function getEtab($id,$text){
        if(!is_numeric($text)){//c pas un id
    $idSpec=$this->testChaine($text,'etablissement');
    update($id,array('etablissement'=>$idSpec),'prospect');
}
    }
    /*
     * test if chaine add in table or not
     */
    function testChaine($text,$table,$idEtr=null){
        $Recherche=get("*",$table,array(
            'nom='=>$text
        ));
        $addArray=array(
            'id'=>'',
            'nom'=>$text
        );
        if($idEtr){
            $addArray['gouv_id']=$idEtr;
        }
         if($Recherche['total']>0){
             //existe déja
             return $Recherche['reponse'][0]['id'];
         }else{
             //ajouter la chaine au table
             return add($addArray,$table);
         }
    }
function filterShow($Titre,$Liste,$table, $var){
     if(count($Liste)>0){
                                echo "<div class=\"pull-left \" style=\"margin-right: 5px;min-width: 20%;\"><h5>$Titre</h5> <ul>";
                                foreach ($Liste as $k=>$v):
                                    echo "<li>".getinfo($v, $table, $var)."</li>";
                                endforeach;  
                                echo '</ul></div>';
                            }
}
function testAffectation($IdProd,$idPRo){
    $Cible=get("*",'cible',array("prod_id="=>$IdProd,"prospect="=>$idPRo),'AND');
    if($Cible['total']>0){
        return $Cible['reponse'][0];
    }else{
        return false;
    }
}
/*
 * function to get access do think by :p
 */
function getListe($name,$idv){
    // test if user not admin and not super
    $Type=$_SESSION['user']['type'];
    $id=$_SESSION['user']['id'];
    if($Type==1 || $Type==2){
        return TRUE;
    }else{
        //get user liste
        $userListes=get("*",'liste',array('user_id='=>$id)); 
        if($userListes['total']==0){
            return FALSE;
        }else{
            $bool=$this->testValidation(explode("@_@", $userListes['reponse'][0][$name]),$idv);
            return $bool;
         }
        
}
    }
    function testValidation($array,$val){ 
       
         if($array!=NULL){
             if(in_array($val,$array)===false) {
                 return false; 
             } 
         }
         return true;
    }
    function getDemande($userid){
        $Type=$_SESSION['user']['type'];
    $id=$_SESSION['user']['id'];
    switch ($Type) {
        case 1:
            return true; 
        case 2:
            return $this->getSup($id, $userid); 
    }
        
    } 
    function getSup($supID,$userid){
        $ind=get("*",'liste',array('supID='=>$supID,'user_id='=>$userid));
        if($ind['total']>0){
            return true;
        }else{
            return false;
        }
    }
    function countVisite ($user,$de,$a,$activite,$type,$eq){
        $Visite=array();$c=0;
        $where['date_visite >= ' ]=$de;
        $where['date_visite <= ' ]=$a;
        if($user)$where['id_visiteur=']=$user;
        $ListeVi=get('*','visite',$where);
        foreach($ListeVi['reponse'] as $vi):
           $prosActivite=getinfo($vi['id_pros'],'prospect','activite');
           $prosType=getinfo($vi['id_pros'],'prospect','spec');
        if($prosActivite==$activite && in_array($prosType,$type)==$eq){
            $Visite[$c++]=$vi;
        }
        endforeach;
        return $Visite;
    }
    function countGlobal ($Cond){
        global $PDO;
        $sqlTotal = "SELECT COUNT(*) as total FROM  visite WHERE $Cond";
        $q = $PDO->prepare($sqlTotal);
        $q->execute();
        $tot = $q->fetchAll(PDO::FETCH_ASSOC);
        return $tot[0]['total'];
    }
    function getWeek($week, $year) {
        $dto = new DateTime();
        $result['start'] = $dto->setISODate($year, $week, 1)->format('Y-m-d');
        $result['end'] = $dto->setISODate($year, $week, 7)->format('Y-m-d');
        return $result;
    }
    function createDateRangeArray($strDateFrom,$strDateTo)
    {
        // takes two dates formatted as YYYY-MM-DD and creates an
        // inclusive array of the dates between the from and to dates.

        // could test validity of dates here but I'm already doing
        // that in the main script

        $aryRange=array();

        $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
        $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

        if ($iDateTo>=$iDateFrom)
        {
            array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo)
            {
                $iDateFrom+=86400; // add 24 hours
                array_push($aryRange,date('Y-m-d',$iDateFrom));
            }
        }
        return $aryRange;
    }
    function CheckDate($begin,$end,$id_pros,$id_visiteur){
        $paymentDate = date('Y-m-d');
        $paymentDate=date('Y-m-d', strtotime($paymentDate));;
        //echo $paymentDate; // echos today!
        $contractDateBegin = date('Y-m-d', strtotime($begin));
        $contractDateEnd = date('Y-m-d', strtotime($end));
        if($paymentDate < $contractDateBegin){
            $cls="btn-primary";
        }elseif($paymentDate > $contractDateEnd){
            $visite=get("*",'visite',array(
                'id_visiteur='=>$id_visiteur,
                'id_pros='=>$id_pros
            ));
            if($visite['total']>0)  $cls= "btn-success";
            else $cls= "btn-danger";
        }
        elseif (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd))
        {
            $visite=get("*",'visite',array(
                'id_visiteur='=>$id_visiteur,
                'id_pros='=>$id_pros
            ));
            if($visite['total']>0)  $cls= "btn-success";
            else $cls="btn-primary";
        }
        else
        { // test if hi visted or not
            $visite=get("*",'visite',array(
                'id_visiteur='=>$id_visiteur,
                'id_pros='=>$id_pros
            ));
            if($visite['total']>0)  $cls= "btn-success";
            else $cls= "btn-danger";
        }
        return $cls;
    }
}
$StdFunctions = new StdFunctions();
