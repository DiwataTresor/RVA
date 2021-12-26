<?php
	$num_mouv=$_REQUEST['p2'];
	include('../../manager/bd/cnx.php');
	$mouvement=mouv($num_mouv,$bdd)
?>
<script type="application/javascript">
	$(document).ready(function(){
		modif_ville_nat();
		$("#nature_vol").val("<?php echo $mouvement['ta']['Type_mouv']; ?>");
		$("#imm").text("<?php echo $mouvement['ta']['Code_imm']; ?>");
		$("#num_form").val("<?php echo $mouvement['ta']['Num_form']; ?>");
		$("#temps").val("<?php echo $mouvement['ta']['Temps']; ?>");
		$("#niv_vol").val("<?php echo $mouvement['ta']['Nv_vol']; ?>");
		$("#dt").val("<?php echo $mouvement['ta']['Date_mouv']; ?>");
		$("#heure").val("<?php echo $mouvement['ta']['Heure_mouv']; ?>");
		
		$("#ex_att_nat_arr").val("<?php echo $mouvement['ta']['Ex_att']; ?>");
		$("#ex_stt_nat_arr").val("<?php echo $mouvement['ta']['Ex_stt']; ?>");
		$("#ex_stg_nat_arr").val("<?php echo $mouvement['ta']['Ex_stg']; ?>");
		$("#ex_bal_nat_arr").val("<?php echo $mouvement['ta']['Ex_bal']; ?>");
		$("#ex_pax_nat_arr").val("<?php echo $mouvement['ta']['Ex_pax']; ?>");
		$("#ex_fret_nat_arr").val("<?php echo $mouvement['ta']['Ex_fret']; ?>");
		$("#ex_route_nat_arr").val("<?php echo $mouvement['ta']['Ex_rout']; ?>");
		
	//========================================================================================	
		//alert(<?php echo intval($mouvement['td']['Num_form']); ?>);
		$("#num_form_dep").val("<?php echo intval($mouvement['td']['Num_form']); ?>");
		$("#nature_vol_dep").val("<?php echo $mouvement['td']['Type_mouv']; ?>");
		$("#temps_dep").val("<?php echo $mouvement['td']['Temps']; ?>");
		$("#niv_vol_dep").val("<?php echo $mouvement['td']['Nv_vol']; ?>");
		$("#dt_dep").val("<?php echo $mouvement['td']['Date_mouv']; ?>");
		$("#heure_dep").val("<?php echo $mouvement['td']['Heure_mouv']; ?>");
		$("#stat").val("<?php echo $mouvement['td']['Stat']; ?>");
		$("#compt_enr").val("<?php echo $mouvement['td']['Compt_enr']; ?>");
		$("#formulaire").val("<?php echo $mouvement['td']['Formu']; ?>");
		$("#anti_inc").val("<?php echo $mouvement['td']['Anti_inc']; ?>");
		
		//$("#nature_vol").val("N");
	});
</script>
<div class="panel panel-default">
	<div class="panel-heading">MOUVEMENT</div>
    <div class="panel-body">
    	 <div class="mt-1 pt-1">
          <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Arriv&eacute;</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Depart</a></li>
              </ul>
        
              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                	<form onSubmit="modif_mouv_arr(<?php echo $mouvement['ta']['Id_mouv']; ?>); return false">
                    <div class="row p-1">
                    	<div class="col s12 m2">Immatr <span id="imm"></span></div>
                        <div class="col s12 m2 input-group"><label class="input-group-addon">Date </label><input type="date" id="dt" required class="browser-default form-control"></div>
                        <div class="col s12 m2 input-group"><span class="input-group-addon">Heure</span><input type="time" id="heure" required class="browser-default form-control"></div>
                    </div>
                      <div class="row p-1">
                            <div class="col s12 m3 input-group">
                                <label class="input-group-addon">Nature</label>
                                <select class="browser-default form-control" id="nature_vol">
                                    <option value="I">International</option>
                                    <option value="N">National</option>
                                </select>
                            </div>
                            <div class="col s12 m2 input-group">
                                <label class="input-group-addon">N° Form</label>
                                <input type="text" class="browser-default form-control" required id="num_form">
                            </div>
                            <div class="col s12 m2 input-group">
                                <label class="input-group-addon">Temps</label>
                                <select class="browser-default form-control" id="temps">
                                    <option value="B">Bon</option>
                                    <option value="M">Mauvais</option>
                                </select>
                            </div>
                            <div class="col s12 m2 input-group">
                                <label class="input-group-addon">Niv vol</label>
                                <input type="text" class="browser-default form-control" required id="niv_vol">
                            </div>
                      </div>
                      <div class="p-1 center">
                      	<button class="btn btn-success">Modifier</button>
                      </div>
                      </form>
                  	 <form onSubmit="modif_exon_arr(<?php echo $mouvement['ta']['Id_mouv']; ?>); return false">
                     <div class="row w3-border w3-round p-05 m-05">
                       
                        <div class="row bold p-1 pl-2" align="left">EXONERATION </div>
                        <div class="col s12 m2 input-group">
                            <span class="input-group-addon">ATT</span>
                            <select class="browser-default form-control" id="ex_att_nat_arr">
                                <option value="N">Non</option>
                                <option value="O">Oui</option>
                            </select>
                        </div>
                        
                        <div class="col s12 m2 input-group">
                            <span class="input-group-addon">STT</span>
                            <select class="browser-default form-control" id="ex_stt_nat_arr">
                                <option value="N">Non</option>
                                <option value="O">Oui</option>
                            </select>
                        </div>
                        
                        <div class="col s12 m2 input-group">
                            <span class="input-group-addon">STG</span>
                            <select class="browser-default form-control" id="ex_stg_nat_arr">
                                <option value="N">Non</option>
                                <option value="O">Oui</option>
                            </select>
                        </div>
                        
                        <div class="col s12 m2 input-group">
                            <span class="input-group-addon w3-small">BAL</span>
                            <select class="browser-default form-control" id="ex_bal_nat_arr">
                                <option value="N">Non</option>
                                <option value="O">Oui</option>
                            </select>
                        </div>
                        
                        <div class="col s12 m2 input-group">
                            <span class="input-group-addon w3-small">PAX</span>
                            <select class="browser-default form-control" id="ex_pax_nat_arr">
                                <option value="N">Non</option>
                                <option value="O">Oui</option>
                            </select>
                        </div>
                        
                        <div class="col s12 m2 input-group">
                            <span class="input-group-addon w3-small">FRET</span>
                            <select class="browser-default form-control" id="ex_fret_nat_arr">
                                <option value="N">Non</option>
                                <option value="O">Oui</option>
                            </select>
                        </div>
                        <div class="col s12 m2 input-group">
                            <span class="input-group-addon w3-small">ROUTE</span>
                            <select class="browser-default form-control" id="ex_route_nat_arr">
                                <option value="N">Non</option>
                                <option value="O">Oui</option>
                            </select>
                        </div>                      
                    </div>
                    	<p class="p-1 center">
                    		<button class="btn btn-success" type="submit">Modifier</button>
                    	</p>   
                    </form> 
         <!--================ BOUTTON ============================-->          
                    
         <!--================= ESCALES===========================-->           
                    <p>
                    	<?php
						$sa="select * from escale,pt_emplacement where escale.Prov_dest=pt_emplacement.Id_pt and escale.Id_mouv='$num_mouv' and escale.Sens='A'"; 
						$ea=mysqli_query($bdd,$sa); $ta=mysqli_fetch_array($ea);
						$num=1;
						do
						{ 
							$ligne="arr_nat_".$num;
							if($mouvement['ta']['Type_mouv']=='N')
							{ ?>
								<div class="w3-border w3-round p-1 mb-1">
                                	<div><?php echo $num." Escale"; ?><hr /></div>
                                    <div class="row" id="<?php echo $ligne; ?>">
                                    <form onSubmit="modif_esc_nat_arr('<?php echo $ligne; ?>'); return false">
                                    	<input type="hidden" class="id_esc" value="<?php echo $ta['Id_esc']; ?>">
                                        <div class="col s12 m4 input-group">
                                            <label class="input-group-addon">Prov</label>
                                            <select class="browser-default form-control ville_nat prov" id="esc1_ville">
                                                <option value="<?php echo $ta['Prov_dest']; ?>" selected><?php echo ($ta['Code_pt']); ?></option>
                                            </select>
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Ad</label>
                                            <input type="text" class="browser-default form-control ad" required value="<?php echo $ta['Ad']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Ch</label>
                                            <input type="text" class="browser-default form-control ch" required value="<?php echo $ta['Ch']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Inf</label>
                                            <input type="text" class="browser-default form-control inf"  required value="<?php echo $ta['Inf']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Tra</label>
                                            <input type="text" class="browser-default form-control tra"  required value="<?php echo $ta['Tra']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Pec</label>
                                            <input type="text" class="browser-default form-control pec" required value="<?php echo $ta['Pec']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Loc</label>
                                            <input type="text" class="browser-default form-control loc" required value="<?php echo $ta['Loc']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Trat</label>
                                            <input type="text" class="browser-default form-control trat" required value="<?php echo $ta['Trat']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Ptt</label>
                                            <input type="text" class="browser-default form-control ptt" required value="<?php echo $ta['Ptt']; ?>">
                                        </div>
                                        <div class="row" style="clear:both;" align="center">
                                        	<button class="btn btn-success" type="submit">Modifier</button>
                                        </div>
                                      </form>
                                    </div>
                                </div>
							<?php
                            }else
							{ ?>
								<div class="w3-border w3-round p-1 mb-1">
                                	<div><?php echo $num." Escale"; ?><hr /></div>
                                    <div class="row" id="<?php echo $ligne; ?>">
                                    <form onSubmit="modif_esc_int_arr('<?php echo $ligne; ?>'); return false">
                                    	<input type="hidden" class="id_esc" value="<?php echo $ta['Id_esc']; ?>">
                                        <div class="col s12 m4 input-group">
                                            <label class="input-group-addon">Prov</label>
                                            <select class="browser-default form-control ville_int prov" required id="ville_pr_arr">
                                            	<?php 
													$req_vill_int="select * from pt_emplacement where Type='V'"; 
													$e_vill_int=mysqli_query($bdd,$req_vill_int);
													$t_vill_int=mysqli_fetch_array($e_vill_int); ?>
                                                <option value="<?php echo $ta['Id_pt']; ?>" selected><?php echo ($ta['Code_pt']); ?></option>
													<?php
                                                    do
													{ ?>
                                                <option value="<?php echo $t_vill_int['Id_pt']; ?>"><?php echo ($t_vill_int['Code_pt']); ?></option>
                                                	<?php
													}while($t_vill_int=mysqli_fetch_array($e_vill_int));
													?>
                                            </select>
                                        </div>
                                         <div class="col s12 m4 input-group">
                                            <label class="input-group-addon">Point d'ent</label>
                                             <select class="browser-default form-control ville_int pt" required id="pt_arr">
                                            	<?php 
													$pt=$ta['Pt_ent'];
													$req_vill_int="select * from pt_emplacement where pt_emplacement.Id_pt='$pt'"; 
													$e_vill_int=mysqli_query($bdd,$req_vill_int);
													$t_vill_int=mysqli_fetch_array($e_vill_int); ?>
                                                    <option value="<?php echo $t_vill_int['Id_pt']; ?>" selected><?php echo ($t_vill_int['Code_pt']); ?></option>
                                                    
                                                   	<?php
													$req_vill_int="select * from pt_emplacement where pt_emplacement.Type='P' order by Code_pt"; 
													$e_vill_int=mysqli_query($bdd,$req_vill_int);
													$t_vill_int=mysqli_fetch_array($e_vill_int); 
													do
													{
														$id_pt=$t_vill_int['Id_pt'];
														$code_pt=$t_vill_int['Code_pt'];
														echo "<option value='$id_pt'>".$code_pt."</option>";
													}while($t_vill_int=mysqli_fetch_array($e_vill_int));
													?>
                                            </select>
                                            
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Ad</label>
                                            <input type="text" class="browser-default form-control ad" required value="<?php echo $ta['Ad']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Ch</label>
                                            <input type="text" class="browser-default form-control ch" required value="<?php echo $ta['Ch']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Inf</label>
                                            <input type="text" class="browser-default form-control inf"  required value="<?php echo $ta['Inf']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Tra</label>
                                            <input type="text" class="browser-default form-control tra"  required value="<?php echo $ta['Tra']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Pec</label>
                                            <input type="text" class="browser-default form-control pec" required value="<?php echo $ta['Pec']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Loc</label>
                                            <input type="text" class="browser-default form-control loc" required value="<?php echo $ta['Loc']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Trat</label>
                                            <input type="text" class="browser-default form-control trat" required value="<?php echo $ta['Trat']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Ptt</label>
                                            <input type="text" class="browser-default form-control ptt" required value="<?php echo $ta['Ptt']; ?>">
                                        </div>
                                        <div class="row" style="clear:both;" align="center">
                                        	<button class="btn btn-success" type="submit">Modifier</button>
                                        </div>
                                      </form>
                                    </div>
                                </div>
							<?php
                            }
							$num++;
                        }while($ta=mysqli_fetch_array($ea));
						?>
                    </p>
                </div>
  <!--=============================   PANEL 2========================-->
                <div role="tabpanel" class="tab-pane" id="profile">
                  <form onSubmit="modif_mouv_dep(<?php echo $mouvement['td']['Id_mouv']; ?>); return false">
                    <div class="row p-1">
                        <div class="col s12 m2 input-group">
                        	<label class="input-group-addon">Date </label><input type="date" id="dt_dep" required class="browser-default form-control"></div>
                        <div class="col s12 m2 input-group">
                        	<span class="input-group-addon">Heure</span><input type="time" id="heure_dep" required class="browser-default form-control"></div>
                    </div>
                      <div class="row p-1">
                            <div class="col s12 m3 input-group">
                                <label class="input-group-addon">Nature</label>
                                <select class="browser-default form-control" id="nature_vol_dep">
                                    <option value="I">International</option>
                                    <option value="N">National</option>
                                </select>
                            </div>
                            <div class="col s12 m2 input-group">
                                <label class="input-group-addon">N° Form</label>
                                <input type="text" class="browser-default form-control" min="0" required id="num_form_dep">
                            </div>
                            <div class="col s12 m2 input-group">
                                <label class="input-group-addon">Temps</label>
                                <select class="browser-default form-control" id="temps_dep">
                                    <option value="B">Bon</option>
                                    <option value="M">Mauvais</option>
                                </select>
                            </div>
                            <div class="col s12 m2 input-group">
                                <label class="input-group-addon">Niv vol</label>
                                <input type="text" class="browser-default form-control" required id="niv_vol_dep">
                            </div>
                            <div class="col s12 m2 input-group">
                                <label class="input-group-addon">Station</label>
                                <select class="browser-default form-control" required id="stat">
                                    <option value="N">Aucun stat.</option>
                                    <option value="T">Tarmac</option>
                                    <option value="G">Garage</option>
                                </select>
                            </div>
                            
                            <div class="col s12 m2 input-group">
                                <label class="input-group-addon">Compt. Enr</label>
                                <input type="number" class="browser-default form-control right" min="0" required id="compt_enr" />
                            </div>
                            <div class="col s12 m2 input-group">
                                <label class="input-group-addon">Formulaire</label>
                                <input type="number" class="browser-default form-control right" min="0" required id="formulaire" />
                            </div>
                            <div class="col s12 m2 input-group">
                                <span class="input-group-addon">Ass. Anti-inc</span>
                                <select  class="browser-default form-control right" required id="anti_inc">
                                    <option value="N">Non</option>
                                    <option value="O">Oui</option>
                                </select>
                            </div>
                      </div>
                      <div class="p-1 center">
                      	<button class="btn btn-success">Modifier</button>
                      </div>
                      </form>
                  	 <form onSubmit="modif_exon_dep(<?php echo $mouvement['td']['Id_mouv']; ?>); return false">
                     <div class="row w3-border w3-round p-05 m-05">
                       
                        <div class="row bold p-1 pl-2" align="left">EXONERATION </div>
                        <div class="col s12 m2 input-group">
                            <span class="input-group-addon">ATT</span>
                            <select class="browser-default form-control" id="ex_att_nat_dep">
                                <option value="N">Non</option>
                                <option value="O">Oui</option>
                            </select>
                        </div>
                        
                        <div class="col s12 m2 input-group">
                            <span class="input-group-addon">STT</span>
                            <select class="browser-default form-control" id="ex_stt_nat_dep">
                                <option value="N">Non</option>
                                <option value="O">Oui</option>
                            </select>
                        </div>
                        
                        <div class="col s12 m2 input-group">
                            <span class="input-group-addon">STG</span>
                            <select class="browser-default form-control" id="ex_stg_nat_dep">
                                <option value="N">Non</option>
                                <option value="O">Oui</option>
                            </select>
                        </div>
                        
                        <div class="col s12 m2 input-group">
                            <span class="input-group-addon w3-small">BAL</span>
                            <select class="browser-default form-control" id="ex_bal_nat_dep">
                                <option value="N">Non</option>
                                <option value="O">Oui</option>
                            </select>
                        </div>
                        
                        <div class="col s12 m2 input-group">
                            <span class="input-group-addon w3-small">PAX</span>
                            <select class="browser-default form-control" id="ex_pax_nat_dep">
                                <option value="N">Non</option>
                                <option value="O">Oui</option>
                            </select>
                        </div>
                        
                        <div class="col s12 m2 input-group">
                            <span class="input-group-addon w3-small">FRET</span>
                            <select class="browser-default form-control" id="ex_fret_nat_dep">
                                <option value="N">Non</option>
                                <option value="O">Oui</option>
                            </select>
                        </div>
                        <div class="col s12 m2 input-group">
                            <span class="input-group-addon w3-small">ROUTE</span>
                            <select class="browser-default form-control" id="ex_route_nat_dep">
                                <option value="N">Non</option>
                                <option value="O">Oui</option>
                            </select>
                        </div>                      
                    </div>
                    	<p class="p-1 center">
                    		<button class="btn btn-success" type="submit">Modifier</button>
                    	</p>   
                    </form> 
         <!--================ BOUTTON ============================-->          
                    
         <!--================= ESCALES===========================-->           
                    <p>
                    	<?php
						$sd="select * from escale,pt_emplacement where escale.Prov_dest=pt_emplacement.Id_pt and escale.Id_mouv='$num_mouv' and escale.Sens='D'"; 
						$ed=mysqli_query($bdd,$sd); $td=mysqli_fetch_array($ed);
						$num=1;
						do
						{ 
							$ligne="dep_nat_".$num;
							if($mouvement['td']['Type_mouv']=='N')
							{ ?>
								<div class="w3-border w3-round p-1 mb-1">
                                	<div><?php echo $num." Escale"; ?><hr /></div>
                                    <div class="row" id="<?php echo $ligne; ?>">
                                    <form onSubmit="modif_esc_nat_arr('<?php echo $ligne; ?>'); return false">
                                    	<input type="hidden" class="id_esc" value="<?php echo $td['Id_esc']; ?>">
                                        <div class="col s12 m4 input-group">
                                            <label class="input-group-addon">Prov</label>
                                            <select class="browser-default form-control ville_nat prov" required id="esc1_ville">
                                                <option value="<?php echo $td['Prov_dest']; ?>" selected><?php echo ($td['Code_pt']); ?></option>
                                            </select>
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Ad</label>
                                            <input type="text" class="browser-default form-control ad" required value="<?php echo $td['Ad']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Ch</label>

                                            <input type="text" class="browser-default form-control ch" required value="<?php echo $td['Ch']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Inf</label>
                                            <input type="text" class="browser-default form-control inf"  required value="<?php echo $td['Inf']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Tra</label>
                                            <input type="text" class="browser-default form-control tra"  required value="<?php echo $td['Tra']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Pec</label>
                                            <input type="text" class="browser-default form-control pec" required value="<?php echo $td['Pec']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Loc</label>
                                            <input type="text" class="browser-default form-control loc" required value="<?php echo $td['Loc']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Trat</label>
                                            <input type="text" class="browser-default form-control trat" required value="<?php echo $td['Trat']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Ptt</label>
                                            <input type="text" class="browser-default form-control ptt" required value="<?php echo $td['Ptt']; ?>">
                                        </div>
                                        <div class="row" style="clear:both;" align="center">
                                        	<button class="btn btn-success" type="submit">Modifier</button>
                                        </div>
                                      </form>
                                    </div>
                                </div>
							<?php
                            }else
							{ ?>
								<div class="w3-border w3-round p-1 mb-1">
                                	<div><?php echo $num." Escale"; ?><hr /></div>
                                    <div class="row" id="<?php echo $ligne; ?>">
                                    <form onSubmit="modif_esc_int_dep('<?php echo $ligne; ?>'); return false">
                                    	<input type="hidden" class="id_esc" value="<?php echo $td['Id_esc']; ?>">
                                        <div class="col s12 m4 input-group">
                                            <label class="input-group-addon">Prov</label>
                                            <select class="browser-default form-control ville_int prov" required id="ville_pr_dep">
                                            	<?php 
													$req_vill_int="select * from pt_emplacement where Type='V'"; 
													$e_vill_int=mysqli_query($bdd,$req_vill_int);
													$t_vill_int=mysqli_fetch_array($e_vill_int); ?>
                                                <option value="<?php echo $td['Id_pt']; ?>" selected><?php echo ($td['Code_pt']); ?></option>
													<?php
                                                    do
													{ ?>
                                                <option value="<?php echo $t_vill_int['Id_pt']; ?>"><?php echo ($t_vill_int['Code_pt']); ?></option>
                                                	<?php
													}while($t_vill_int=mysqli_fetch_array($e_vill_int));
													?>
                                            </select>
                                        </div>
                                         <div class="col s12 m4 input-group">
                                            <label class="input-group-addon">Point d'ent</label>
                                             <select class="browser-default form-control ville_int pt" required id="pt_dep">
                                            	<?php 
													$pt=$td['Pt_ent'];
													$req_vill_int="select * from pt_emplacement where pt_emplacement.Id_pt='$pt'"; 
													$e_vill_int=mysqli_query($bdd,$req_vill_int);
													$t_vill_int=mysqli_fetch_array($e_vill_int); ?>
                                                    <option value="<?php echo $t_vill_int['Id_pt']; ?>" selected><?php echo ($t_vill_int['Code_pt']); ?></option>
                                                    
                                                   	<?php
													$req_vill_int="select * from pt_emplacement where pt_emplacement.Type='P' order by Code_pt"; 
													$e_vill_int=mysqli_query($bdd,$req_vill_int);
													$t_vill_int=mysqli_fetch_array($e_vill_int); 
													do
													{
														$id_pt=$t_vill_int['Id_pt'];
														$code_pt=$t_vill_int['Code_pt'];
														echo "<option value='$id_pt'>".$code_pt."</option>";
													}while($t_vill_int=mysqli_fetch_array($e_vill_int));
													?>
                                            </select>
                                            
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Ad</label>
                                            <input type="text" class="browser-default form-control ad" required value="<?php echo $td['Ad']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Ch</label>
                                            <input type="text" class="browser-default form-control ch" required value="<?php echo $td['Ch']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Inf</label>
                                            <input type="text" class="browser-default form-control inf"  required value="<?php echo $td['Inf']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Tra</label>
                                            <input type="text" class="browser-default form-control tra"  required value="<?php echo $td['Tra']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Pec</label>
                                            <input type="text" class="browser-default form-control pec" required value="<?php echo $td['Pec']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Loc</label>
                                            <input type="text" class="browser-default form-control loc" required value="<?php echo $td['Loc']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Trat</label>
                                            <input type="text" class="browser-default form-control trat" required value="<?php echo $td['Trat']; ?>">
                                        </div>
                                        <div class="col s12 m2 input-group">
                                            <label class="input-group-addon">Ptt</label>
                                            <input type="text" class="browser-default form-control ptt" required value="<?php echo $td['Ptt']; ?>">
                                        </div>
                                        <div class="row" style="clear:both;" align="center">
                                        	<button class="btn btn-success" type="submit">Modifier</button>
                                        </div>
                                      </form>
                                    </div>
                                </div>
							<?php
                            }
							$num++;
                        }while($td=mysqli_fetch_array($ed));
						?>
                    </p>
                </div>                
              </div>
     </div>
    </div>
</div>