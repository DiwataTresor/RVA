$s_acc="select * from rda where rda.Date_rda='$dt'";
		$e_acc=mysqli_query($bdd,$s_acc); $t_acc=mysqli_fetch_array($e_acc); $n_acc=mysqli_num_rows($e_acc);
		$r_acc=array();
		if($n_acc==0)
		{
			$r_acc[]=array("n"=>0);
		}else
		{
			do
			{
				if($t_acc['Monn_acc']=='USD')
				{
					$rda_mt_usd=$t_acc['Mt_acc'];
					$rda_mt_tva_usd=(($rda_mt_usd*16)/100);
					$rda_mt_tt_usd=$rda_mt_usd+$rda_mt_tva_usd;

					$rda_mt_cdf=0;
					$rda_mt_tva_cdf=0;
					$rda_mt_tt_cdf=0;	

					//========================= CALCUL SOUS TOTAL 
					$st_rda_usd=$st_rda_usd+$rda_mt_usd;
					$st_rda_tva_usd=$st_rda_tva_usd+$rda_mt_tva_usd;
					$st_rda_tt_usd=$rda_mt_tt_usd+$rda_mt_tt_usd;
					
				}else
				{
					$rda_mt_cdf=$t_acc['Mt_acc'];
					$rda_mt_tva_cdf=(($rda_mt_cdf*16)/100);
					$rda_mt_tt_cdf=$rda_mt_cdf+$rda_mt_tva_cdf;	

					$rda_mt_usd=0;
					$rda_mt_tva_usd=0;
					$rda_mt_tt_usd=0;
					//========================= CALCUL SOUS TOTAL 
					$st_rda_cdf=$st_rda_cdf+$rda_mt_cdf;
					$st_rda_tva_cdf=$st_rda_tva_cdf+$rda_mt_tva_cdf;
					$st_rda_tt_cdf=$rda_mt_tt_cdf+$rda_mt_tt_cdf;	
				}
				$r_acc[]=array("n"=>$n_acc,
						"id"=>$t_acc['Id_acc'],
						"num_acc"=>$t_acc['Num_long'],
						"rda_mt_cdf"=>$rda_mt_cdf,
						"rda_mt_tva_cdf"=>$rda_mt_tva_cdf,
						"rda_mt_tt_cdf"=>$rda_mt_tt_cdf,

						"rda_mt_usd"=>$rda_mt_usd,
						"rda_mt_tva_usd"=>$rda_mt_tva_usd,
						"rda_mt_tt_usd"=>$rda_mt_tt_usd
				);
			}while($t_rda=mysqli_fetch_array($e_acc));

		}