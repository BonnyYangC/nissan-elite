<?PHP

	$page='';
	$content='';
	if (isset($_GET['page']) || isset($_POST['page']) )
	{
		$page = strtolower( isset($_GET['page']) ? $_GET['page'] : $_POST['page']);
	}
	switch ($page)
	{
		case 'metrics':
			$override_role = (isset($_GET['override_role']) && !empty($_GET['override_role'])) ? $_GET['override_role'] : '';

			/* Assume single/current role. */
			$data=$Application['User']['Results'];

			/* If user has multiple roles and client wants to view data for a specific role,
			override the data to be displayed for that role. */
			if ($use_override = in_array($override_role, array_keys($Application['User']['multiple_role_metrics']))) {
				$data = $Application['User']['multiple_role_metrics'][$override_role]['Results'];
			}
			$position_to_use = $use_override ? nissan_get_abbr_from_table_name($override_role) : $Application['User']['position'];

			switch ($position_to_use)
			{
				case 'R':	// Retail Sales Consultant
				case 'F':	// Fleet Sales Consultant
				case 'FM':	// Fleet Sales Manager
					$new=$recommendation=$FU=$training=$matched_results=$sales_results=$recommendation_results=$fu_results='';
					$class='nissangray-light-back';
					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						$class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
						if(isset($data[date("M-Y", $period)]))
						{
							$new.=(empty($new) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['credit_actual_sales'] . "]";
							$recommendation.=(empty($recommendation) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['ce_recommendation'] . "]";
							$FU.=(empty($FU) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['follow_up_credit'] . "]";
							$training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['pathway'] . "," .  $data[date("M-Y", $period)]['training'] . "," .  $data[date("M-Y", $period)]['classroom'] . "]";

							$sales_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['sales'] . '</td>';
							$recommendation_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['score_recommendation'] . '</td>';
							$fu_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['follow_up_score'] . '</td>';
						}
						else
						{
							$new.=(empty($new) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$recommendation.=(empty($recommendation) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$FU.=(empty($FU) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "',0,0,0]";

							$sales_results.='<td class="' . $class . '">&nbsp;</td>';
							$recommendation_results.='<td class="' . $class . '">&nbsp;</td>';
							$fu_results.='<td class="' . $class . '">&nbsp;</td>';

						}

					}
					$content=read_template("dashboard-metrics-r.html", array(
																				"NEW-VEHICLE-SALES" => $new,
																				"SALES-RECOMMENDATION" => $recommendation,
																				"FOLLOW-UP-CREDITS" => $FU,
																				"SALES-RESULTS" => $sales_results,
																				"RECOMMENDATION-RESULTS" => $recommendation_results,
																				"FOLLOWUP-RESULTS" => $fu_results,
																				"TRAINING" => $training
					));
					break;
				case 'M':	// Sales Manager
					$matched=$new=$recommendations=$followup=$retail=$training=$matched_results=$sales_results=$recommendation_results=$fu_results=$retail_results='';

					$class='nissangray-light-back';

					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						$class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
						if(isset($data[date("M-Y", $period)]))
						{
							$matched.=(empty($matched) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['order_write_credit'] . "]";
							$new.=(empty($new) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['actual_sales'] . "]";
							$recommendations.=(empty($recommendations) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['ce_recomendation']  . "]";
							$followup.=(empty($followup) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['follow_up_ce'] . "]";
							$retail.=(empty($retail) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['retail_midmth'] . "]";
							$training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['training'] . "," . $data[date("M-Y", $period)]['pathway'] . "," . $data[date("M-Y", $period)]['classroom']  . "]";


							$matched_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['order_write_variation'] . '</td>';
							$sales_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['percent'] . '%</td>';
							$recommendation_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['score_recommendation'] . '</td>';
							$fu_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['follow_up_score'] . '</td>';
							$retail_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['retail_percentage']*100 . '%</td>';
						}
						else
						{
							$matched.=(empty($matched) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$new.=(empty($new) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$recommendations.=(empty($recommendations) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$followup.=(empty($followup) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$retail.=(empty($retail) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "',0,0,0]";

							$matched_results.='<td class="' . $class . '">&nbsp;</td>';
							$sales_results.='<td class="' . $class . '">&nbsp;</td>';
							$recommendation_results.='<td class="' . $class . '">&nbsp;</td>';
							$fu_results.='<td class="' . $class . '">&nbsp;</td>';
							$retail_results.='<td class="' . $class . '">&nbsp;</td>';

						}

					}
					$content=read_template("dashboard-metrics-m.html", array(
																				"MATCHED-OW" => $matched,
																				"MATCHED-OW-RESULTS" => $matched_results,
																				"NEW-VEHICLE-SALES" => $new,
																				"SALES-RESULTS" => $sales_results,
																				"RECOMMENDATIONS" => $recommendations,
																				"RECOMMENDATION-RESULTS" => $recommendation_results,
																				"FOLLOW-UP" => $followup,
																				"FU-RESULTS" => $fu_results,
																				"MIDMTH-RETAIL" => $retail,
																				"RETAIL-RESULTS" => $retail_results,
																				"TRAINING" => $training
					));
					break;
				case 'SC':	// Stock Controller
					$stock=$stock_results=$ow=$ow_results=$retail=$retail_results=$matched=$matched_results=$davo=$davo_results=$training='';

					$class='nissangray-light-back';

					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						$class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
						if(isset($data[date("M-Y", $period)]))
						{
							$stock.=(empty($stock) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['stock_credit'] . "]";
							$ow.=(empty($ow) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['ow_credit'] . "]";
							$retail.=(empty($retail) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['retail_credit'] . "]";
							$matched.=(empty($matched) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['matched_credit'] . "]";
							$davo.=(empty($davo) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['davo_credit'] . "]";
							$training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['training'] . "]";


							$stock_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['stock'],0) . '</td>';
							$ow_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['ow'],0) . '</td>';
							$retail_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['retail']*100,0) . '%</td>';
							$matched_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['matched'],0) . '</td>';
							$davo_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['davo']*100,0) . '%</td>';
						}
						else
						{
							$stock.=(empty($stock) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$ow.=(empty($ow) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$retail.=(empty($retail) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$matched.=(empty($matched) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$davo.=(empty($davo) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "',0]";

							$stock_results.='<td class="' . $class . '">&nbsp;</td>';
							$ow_results.='<td class="' . $class . '">&nbsp;</td>';
							$retail_results.='<td class="' . $class . '">&nbsp;</td>';
							$matched_results.='<td class="' . $class . '">&nbsp;</td>';
							$davo_results.='<td class="' . $class . '">&nbsp;</td>';
						}

					}
					$content=read_template("dashboard-metrics-sc.html", array(
																				"STOCK-COVER" => $stock,
																				"STOCK-COVER-RESULTS" => $stock_results,
																				"OW" => $ow,
																				"OW-RESULTS" => $ow_results,
																				"RETAIL" => $retail,
																				"RETAIL-RESULTS" => $retail_results,
																				"MATCHED" => $matched,
																				"MATCHED-RESULTS" => $matched_results,
																				"DAVO" => $davo,
																				"DAVO-RESULTS" => $davo_results,
																				"TRAINING" => $training
																				));
					break;
				case 'I':	// Finance & Insurance
					$nfsa=$nfsa_results=$emw=$emw_results=$mmu_results=$ins=$mvi_results=$vpi_results=$pkg_results=$penetration=$penetration_results=$fu=$fu_results='';

					$class='nissangray-light-back';

					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						$class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
						if(isset($data[date("M-Y", $period)]))
						{
							$nfsa.=(empty($nfsa) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['credit_actual_sales']) ? '0' : $data[date("M-Y", $period)]['credit_actual_sales']) . "]";
							$emw.=(empty($emw) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['credits_emw']) ? '0' : $data[date("M-Y", $period)]['credits_emw']) . "," . (empty($data[date("M-Y", $period)]['credits_mmu']) ? '0' : $data[date("M-Y", $period)]['credits_mmu']) . "]";
							$ins.=(empty($ins) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['credits_mvi']) ? '0' : $data[date("M-Y", $period)]['credits_mvi']) . "," . (empty($data[date("M-Y", $period)]['credits_vpi']) ? '0' : $data[date("M-Y", $period)]['credits_vpi']) . "," . $data[date("M-Y", $period)]['credits_pkg'] . "]";
							$penetration.=(empty($penetration) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['credits_penetration']) ? '0' : $data[date("M-Y", $period)]['credits_penetration']) . "]";
							$fu.=(empty($fu) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['credits_fi']) ? '0' : $data[date("M-Y", $period)]['credits_fi']) . "]";


							$nfsa_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_nfsa'],0) . '</td>';
							$emw_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_emw'],0) . '</td>';
							$mmu_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_mmu'],0) . '</td>';
							$mvi_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_mvi'],0) . '</td>';
							$vpi_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_vpi'],0) . '</td>';
							$pkg_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_pkg'],0) . '</td>';
							$penetration_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['penetration']*100,0) . '%</td>';
							$fu_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['score_fi'] . '</td>';
						}
						else
						{
							$nfsa.=(empty($nfsa) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$emw.=(empty($emw) ? '' : ',') . "['" . date("M", $period) . "',0,0]";
							$ins.=(empty($ins) ? '' : ',') . "['" . date("M", $period) . "',0,0,0]";
							$penetration.=(empty($penetration) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$fu.=(empty($fu) ? '' : ',') . "['" . date("M", $period) . "',0]";

							$nfsa_results.='<td class="' . $class . '">&nbsp;</td>';
							$emw_results.='<td class="' . $class . '">&nbsp;</td>';
							$mmu_results.='<td class="' . $class . '">&nbsp;</td>';
							$mvi_results.='<td class="' . $class . '">&nbsp;</td>';
							$vpi_results.='<td class="' . $class . '">&nbsp;</td>';
							$pkg_results.='<td class="' . $class . '">&nbsp;</td>';
							$penetration_results.='<td class="' . $class . '">&nbsp;</td>';
							$fu_results.='<td class="' . $class . '">&nbsp;</td>';
						}

					}
					$content=read_template("dashboard-metrics-i.html", array(
																				"NFSA" => $nfsa,
																				"NFSA-RESULTS" => $nfsa_results,
																				"EMW" => $emw,
																				"EMW-RESULTS" => $emw_results,
																				"MMU-RESULTS" => $mmu_results,
																				"INSURANCE" => $ins,
																				"INSURANCE-MVI-RESULTS" => $mvi_results,
																				"INSURANCE-VPI-RESULTS" => $vpi_results,
																				"INSURANCE-PKG-RESULTS" => $pkg_results,
																				"PENETRATION" => $penetration,
																				"PENETRATION-RESULT" => $penetration_results,
																				"FOLLOW-UP" => $fu,
																				"FOLLOW-UP-RESULTS" => $fu_results
																			));
					break;
				case 'C':	// Financial Controller
$financial=$frequency_results=$ontime_results=$quality=$balance_results=$submission_results=$management=$checklist_results=$meeting_results=$training='';
					$class='nissangray-light-back';

					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						$class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
						if(isset($data[date("M-Y", $period)]))
						{
							$financial.=(empty($financial) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['frequency_credits'] . "," . $data[date("M-Y", $period)]['ontime_credits'] . "]";
							$quality.=(empty($quality) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['balance_credit'] . "," . $data[date("M-Y", $period)]['quality_credit'] . "]";
							$management.=(empty($management) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['checklist_credit'] . "," . $data[date("M-Y", $period)]['meeting_credit'] . "]";
							$training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['training'] . "," . $data[date("M-Y", $period)]['classroom'] . "]";


							$frequency_results.='<td class="' . $class . '">' . ($data[date("M-Y", $period)]['frequency']==1 ? "YES" : "NO") . '</td>';
							$ontime_results.='<td class="' . $class . '">' . ($data[date("M-Y", $period)]['ontime']==1 ? "YES" : "NO") . '</td>';
							$balance_results.='<td class="' . $class . '">' . ($data[date("M-Y", $period)]['balance']==1 ? "YES" : "NO") . '</td>';
							$submission_results.='<td class="' . $class . '"><span class="sm">' . (empty($data[date("M-Y", $period)]['quality']) ? '' : date("d-M", strtotime($data[date("M-Y", $period)]['quality']))) . '</span></td>';
							$checklist_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['checklist'],0) . '</td>';
							$meeting_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['meeting'],0) . '</td>';
						}
						else
						{
							$financial.=(empty($financial) ? '' : ',') . "['" . date("M", $period) . "',0,0]";
							$quality.=(empty($quality) ? '' : ',') . "['" . date("M", $period) . "',0,0]";
							$management.=(empty($management) ? '' : ',') . "['" . date("M", $period) . "',0,0]";
							$training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "',0,0]";

							$frequency_results.='<td class="' . $class . '">&nbsp;</td>';
							$ontime_results.='<td class="' . $class . '">&nbsp;</td>';
							$balance_results.='<td class="' . $class . '">&nbsp;</td>';
							$submission_results.='<td class="' . $class . '">&nbsp;</td>';
							$checklist_results.='<td class="' . $class . '">&nbsp;</td>';
							$meeting_results.='<td class="' . $class . '">&nbsp;</td>';
						}

					}
					$content=read_template("dashboard-metrics-c.html", array (
																				"FINANCIAL" => $financial,
																				"FREQUENCY-RESULTS" => $frequency_results,
																				"ONTIME-RESULTS" => $ontime_results,
																				"QUALITY" => $quality,
																				"BALANCE-RESULTS" => $balance_results,
																				"SUBMISSION-RESULTS" => $submission_results,
																				"MANAGEMENT" => $management,
																				"CHECKLIST-RESULTS" => $checklist_results,
																				"MEETING-RESULTS" => $meeting_results,
																				"TRAINING" => $training
																				));
					break;

				case 'PM':	// Parts Manager
					$grp=$grp_results=$gas=$gas_results=$training='';
					$class='nissangray-light-back';

					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						$class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
						if(isset($data[date("M-Y", $period)]))
						{
							$grp.=(empty($grp) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['grp_credit'] . "]";
							$gas.=(empty($gas) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['gas_credit'] . "]";
							$training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['classroom']  . "]";


							$grp_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['grp']*100,0) . '%</td>';
							$gas_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['gas']*100,0) . '%</td>';
						}
						else
						{
							$grp.=(empty($grp) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$gas.=(empty($gas) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "',0]";

							$grp_results.='<td class="' . $class . '">&nbsp;</td>';
							$gas_results.='<td class="' . $class . '">&nbsp;</td>';
						}

					}
					$content=read_template("dashboard-metrics-pm.html", array(
																				"GRP" => $grp,
																				"GRP-RESULTS" => $grp_results,
																				"GAS" => $gas,
																				"GAS-RESULTS" => $gas_results,
																				"TRAINING" => $training,
																				));
					break;
				case 'PS':	// Parts Sales Rep
					$grp=$grp_results=$training='';
					$class='nissangray-light-back';

					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						$class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
						if(isset($data[date("M-Y", $period)]))
						{
							$grp.=(empty($grp) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['grp_credit'] . "]";
							$training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['classroom']  . "]";


							$grp_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['grp']*100,0) . '%</td>';
						}
						else
						{
							$grp.=(empty($grp) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "',0]";

							$grp_results.='<td class="' . $class . '">&nbsp;</td>';
						}

					}
					$content=read_template("dashboard-metrics-ps.html",array(
																				"GRP" => $grp,
																				"GRP-RESULTS" => $grp_results,
																				"TRAINING" => $training,
																				));
					break;
				case 'SM':	// Service Manager
					$recommendation=$recommendation_results=$clean=$clean_results=$fu=$fu_results=$emw=$emw_results=$training='';
					$class='nissangray-light-back';

					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						$class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
						if(isset($data[date("M-Y", $period)]))
						{
							$recommendation.=(empty($recommendation) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['recommendation_credit'] . "]";
							$clean.=(empty($clean) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['vclean_credit'] . "]";
							$fu.=(empty($fu) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['followup_credit'] . "]";
							$emw.=(empty($emw) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['emw_credit'] . "]";
							$training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['training'] . "," . $data[date("M-Y", $period)]['classroom']  . "]";


							$recommendation_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['recommendation'] . '</td>';
							$clean_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['vclean'] . '</td>';
							$fu_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['followup'] . '</td>';
							$emw_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['emw'],0) . '</td>';
						}
						else
						{
							$recommendation.=(empty($recommendation) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$clean.=(empty($clean) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$fu.=(empty($fu) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$emw.=(empty($emw) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "',0,0]";

							$recommendation_results.='<td class="' . $class . '">&nbsp;</td>';
							$clean_results.='<td class="' . $class . '">&nbsp;</td>';
							$fu_results.='<td class="' . $class . '">&nbsp;</td>';
							$emw_results.='<td class="' . $class . '">&nbsp;</td>';
						}

					}
					$content=read_template("dashboard-metrics-sm.html",array(
																				"RECOMMENDATION" => $recommendation,
																				"RECOMMENDATION-RESULTS" => $recommendation_results,
																				"CLEAN" => $clean,
																				"CLEAN-RESULTS" => $clean_results,
																				"FOLLOWUP" => $fu,
																				"FOLLOWUP-RESULTS" => $fu_results,
																				"EMW" => $emw,
																				"EMW-RESULTS" => $emw_results,
																				"TRAINING" => $training,
																				));
					break;
					$content=read_template("dashboard-metrics-sm.html");
					break;
				case 'SA':	// Service Advisors
					$advice=$advice_results=$emw=$emw_results=$recommendation=$recommendation_results=$fu=$fu_results=$training='';
					$class='nissangray-light-back';

					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						$class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
						if(isset($data[date("M-Y", $period)]))
						{
							$recommendation.=(empty($recommendation) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['trust_credit']) ? '0' : $data[date("M-Y", $period)]['trust_credit']) . "]";
							$emw.=(empty($emw) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['emw_credit']) ? '0' : $data[date("M-Y", $period)]['emw_credit']) . "]";
							$advice.=(empty($advice) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['recom_credit']) ? '0' : $data[date("M-Y", $period)]['recom_credit']) . "]";
							$fu.=(empty($fu) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['fu_credit']) ? '0' : $data[date("M-Y", $period)]['fu_credit']) . "]";
							$training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['training']) ? '0' : $data[date("M-Y", $period)]['training']) . "," .  (empty($data[date("M-Y", $period)]['classroom']) ? '0' : $data[date("M-Y", $period)]['classroom']) ."]";


							$advice_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['trust_score'] . '</td>';
							$emw_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['emw_score'],0) . '</td>';
							$recommendation_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['recom_score'] . '</td>';
							$fu_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['fu_score'] . '</td>';
						}
						else
						{
							$recommendation.=(empty($recommendation) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$emw.=(empty($emw) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$advice.=(empty($advice) ? '' : ',') . "['" . date("M", $period) . ",',0]";
							$fu.=(empty($fu) ? '' : ',') . "['" . date("M", $period) . "',0]";
							$training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "',0,0]";

							$advice_results.='<td class="' . $class . '">&nbsp;</td>';
							$emw_results.='<td class="' . $class . '">&nbsp;</td>';
							$recommendation_results.='<td class="' . $class . '">&nbsp;</td>';
							$fu_results.='<td class="' . $class . '">&nbsp;</td>';

						}
					}
					$content=read_template("dashboard-metrics-sa.html", array(
																				"RECOMMENDATION" => $recommendation,
																				"RECOMMENDATION-RESULTS" => $recommendation_results,
																				"ADVICE" => $advice,
																				"ADVICE-RESULTS" => $advice_results,
																				"EMW" => $emw,
																				"EMW-RESULTS" => $emw_results,
																				"FOLLOW-UP" => $fu,
																				"FOLLOW-UP-RESULTS" => $fu_results,
																				"TRAINING" => $training,
																				));
					break;

			}
			/* Restore data back to current role */
			$data=$Application['User']['Results'];
			break;
		case 'leaderboards':
				$content=read_template("dashboard-rankings.html", array(
																		"MONTH" => "APRIL"
																	));
			break;

		case 'lifetime':
			$data=$Application['User']['Results'];
			$ytd=0;
			$lifetime=0;
			$monthly='';
			$metrics='';
			$min=0;
			$max=100;
			$color="#CCCCC";
			$txt="";
			for($i=0; $i<12; $i++)
			{
				$period=mktime(0,0,0,4+$i,1,2017);
				if(isset($data[date("M-Y", $period)]))
				{
					$ytd=$data[date("M-Y", $period)]['credit_ytd'];
					$lifetime=(isset($data[date("M-Y", $period)]['lifetime']) ? $data[date("M-Y", $period)]['lifetime'] : $data[date("M-Y", $period)]['credit_mtd']);

					$monthly.=(empty($monthly) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['credit_mtd'] . "]";
				}
				else
				{
					$monthly.=(empty($monthly) ? '' : ',') . "['" . date("M", $period) . "',0]";

				}
			}

			if ( $lifetime>= 500000) {
				//	Platinum
					$color='#545454';
					$next_level = "Max Level";
					$lifetime_to_reach_credits = 0;
			} elseif ($lifetime>=325000) {
				//	Gold
					$color='#CD7F32';
					$next_level = "Platinum";
					$lifetime_to_reach_credits = 500000 - $lifetime;
			} elseif ($lifetime >=200000) {
				//	Silver
					$color='#C0C0C0';
					$next_level = "Gold";
					$lifetime_to_reach_credits = 325000 - $lifetime;
			} elseif ($lifetime >= 100000) {
				//	Bronze
					$color='#8C7853';
					$next_level = "Silver";
					$lifetime_to_reach_credits = 200000 - $lifetime;
			} else {
					//$min=$ytd;
					$color='#C0FFC0';
					$next_level = "Bronze";
					$lifetime_to_reach_credits = 100000 - $lifetime;
			}

			$history=',[\'' . (date('Y') - 1) . '\',' . $ytd . ']';
			for ($i=intval(date('Y')) - 2; $i>=1992; $i--)
			{
				if (isset($Application['User']['History'][$i]))
				{
					$history.=',[\'' . $i . '\',' . $Application['User']['History'][$i]['amount'] . ']';
					if (isset($Application['User']['History'][$i]['FF']))
					{
						$history.=',[\'' . $i . ' (FF)\',' . $Application['User']['History'][$i]['FF']['amount'] . ']';
					}
				}
				else
				{
					$history.=',[\'' . $i . '\',0]';
				}

			}

			$lifetime_to_reach_credits = number_format($lifetime_to_reach_credits, 0);

			$lifetime_to_reach = "<span style='color: #ff0000;'>$lifetime_to_reach_credits</span> credits to reach $next_level level.";

			if ($lifetime >= 500000) {
				$lifetime_to_reach = "";
			}




			$content=read_template("dashboard-lifetime.html", array(
																		"MONTH" => "APRIL",
																		"LIFETIME" => number_format($lifetime,0),
																		"LIFETIME-TO-REACH" => $lifetime_to_reach,
																		"LIFETIME-CHART" => number_format($lifetime, 0, '', ''),
																		"COLOR" => $color,
																		"HISTORY" => $history
																	));
			break;

		case 'incentives':

			$current=$thumb=$finished=$past='';
			if ($database->NissanIncentives("CURRENT"))
			{
				$count=0;
				foreach($database->Data as $tmp)
				{
					$count++;
					$current.='<div class="' . ($count==1 ? 'active ' : '') . 'item" data-slide-number="' . ($count-1) . '">
								' . (empty($tmp['pdf']) ? '' : '<a href="http://www.nissanac.com.au/images/incentives/images/pdf/' . $tmp['pdf'] . '" target="_blank">') . '
								<img src="http://www.nissanac.com.au/images/incentives/images/' . $tmp['image'] . '" class="img-responsive">
								' . (empty($tmp['pdf']) ? '' : '</a>') . '</div>';
					$thumb.='<li> <a id="carousel-selector-' . $count . '" ' . ($count==1 ? 'class="selected"' : '') . ' >
									<img src="http://www.nissanac.com.au/images/incentives/images/' . $tmp['image'] . '" width="120" class="img-responsive">
								</a> </li>';

				}
			}
			if ($current=='')
			{
				$current.='<div class="active item" data-slide-number="0">
								<img src="http://www.nissanac.com.au/images/incentives/images/comingsoon.png" class="img-responsive"></div>';
					$thumb.='<li> <a id="carousel-selector-1" class="selected" >
									<img src="http://www.nissanac.com.au/images/incentives/images/comingsoon.png" width="120" class="img-responsive"> </a> </li>';
			}

			if ($database->NissanIncentives("FINISHED"))
			{
				$count=0;
				foreach($database->Data as $tmp)
				{
					$count++;
					$finished.='<div class="col-md-4">
									' . (empty($tmp['pdf']) ? '' : '<a href="http://www.nissanac.com.au/images/incentives/images/pdf/' . $tmp['pdf'] . '" target="_blank">') . '
									<img  class="img-responsive" src="http://www.nissanac.com.au/images/incentives/images/' . $tmp['image'] . '"  alt=""/>
									' . (empty($tmp['pdf']) ? '' : '</a>') . '
									<p>' . $tmp['title'] . '<br>
									' . date("d-M-Y", strtotime($tmp['start'])) . ' to ' . date("d-M-Y", strtotime($tmp['finish'])) . '</p><br>
								</div>' . ($count % 3 ? '' : '<div class="row"></div>');

				}
			}

			if ($database->NissanIncentives("PAST"))
			{
				$count=0;
				foreach($database->Data as $tmp)
				{
					$count++;
					$past.='<div class="col-md-4">
									' . (empty($tmp['pdf']) ? '' : '<a href="http://www.nissanac.com.au/images/incentives/images/pdf/' . $tmp['pdf'] . '" target="_blank">') . '
									<img  class="img-responsive" src="http://www.nissanac.com.au/images/incentives/images/' . $tmp['image'] . '"  alt=""/>
									' . (empty($tmp['pdf']) ? '' : '</a>') . '
									<p>' . $tmp['title'] . '<br>
									' . date("d-M-Y", strtotime($tmp['start'])) . ' to ' . date("d-M-Y", strtotime($tmp['finish'])) . '</p><br>
								</div>' . ($count % 3 ? '' : '<div class="row"></div>');
				}
			}




			$content=read_template("dashboard-incentives.html", array(
																		"CURRENT" => $current,
																		"THUMB" => $thumb,
																		"FINISHED" => $finished,
																		"REGISTERED" => ($Application['User']['Registered']=='YES' ? '&#10004' : 'X'),
																		"REGISTERED-LINK" =>($Application['User']['Registered']=='YES' ? '' : '<a href="http://www.nissan-events.com.au/ac2017/reg" target="_blank">
            <button style="background-color:#c40030; width:100%; margin:0 auto; font-size:11px;" type="button" class="btn btn-primary btn-block">Register Now</button>
            </a>'),
																		"PAST" => $past
																	));
			break;

		case 'calendar':
			$events='';
			if ($database->NissanEvents())
			{
				foreach($database->Data as $evt)
				{
					$events.=(empty($events) ? "" : ",") . '{
                												id: ' . $evt['id'] . ',
																name: \'' . $evt['title'] . '\',
																startDate: new Date(' . date("Y",strtotime($evt['datestamp'])) . ', ' . (date("m",strtotime($evt['datestamp']))-1) . ', ' . (date("d",strtotime($evt['datestamp']))*1) . '),
																endDate: new Date(' . date("Y",strtotime($evt['dateend'])) . ', ' . (date("m",strtotime($evt['dateend']))-1) . ', ' . (date("d",strtotime($evt['dateend']))*1) . ')
															}';

				}
			}
			$content=read_template("dashboard-calendar.html", array("EVENTS" => $events ));
			break;

		case 'membersguide':
			$content=read_template("dashboard-membersguide.html");
			break;

		case 'account':
			$content=read_template("dashboard-account.html", array(
																	"MEMBER-NUMBER" => $Application['User']['employee_code'],
																	"FIRSTNAME" => $Application['User']['firstname'],
																	"LASTNAME" => $Application['User']['lastname'],
																	"SALUTATION" => $Application['User']['salutation'],
																	"DOB" => (empty($Application['User']['dob']) ? '' : date("d-M-Y", strtotime($Application['User']['dob']))),
																	"MOBILE" => $Application['User']['mobile'],
																	"EMAIL" => $Application['User']['email'],
																	"DEALERSHIP" => $Application['User']['company_name'],
																	"DEALER-CODE" => $Application['User']['company_code'],
																	"DEPARTMENT" => $Application['User']['department_name'],
																	"POSITION" => $Application['User']['position_desc']
																));
			break;

		case 'productchallenge':
			$content=read_template("dashboard-productchallenge.html");
			break;

        case 'productchallengewinners':
			$content=read_template("dashboard-productchallengewinners.html");
			break;

        case 'productchallengecurrentevent':
			$content=read_template("dashboard-productchallengecurrentevent.html");
			break;

		case 'mdguild':
			$background='background-color: #231f20; padding:0 25px; color:#FFFFFF';
			$content=read_template("dashboard-mdguild.html");
			break;

		case 'mdguild-members':
			$background = "padding: 0;";
			$content = read_template("dashboard-mdguild-members.html");
			break;

		case 'mdguild-high-achievers':
			$background = "padding: 0;";
			$content = read_template("dashboard-mdguild-high-achievers.html");
			break;

		case 'mdguild-high-achievers-winners':
			$background = "padding: 0;";
			$content = read_template("dashboard-mdguild-high-achievers-winners.html");
			break;

		case 'mdguild-events':
			$background = "padding: 0;";
			$content = read_template("dashboard-mdguild-events.html");
			break;

		case 'mdguild-events-past':
			$background = "padding: 0;";
			$content = read_template("dashboard-mdguild-events-past.html");
			break;

		case 'mdguild-events-high-achievers':
			$background = "padding: 0;";
			$content = read_template("dashboard-mdguild-events-high-achievers.html");
			break;

		# From a previous version
		case 'highachievers':
			$content=read_template("dashboard-achievers.html");
			break;

		case 'faq':
			$content=read_template("dashboard-faq.html");
			break;

		default:
		    // echo '<pre>';
			// var_dump($Application['User']);
			// echo '</pre>'; die();

			/*
				When the user may have multiple roles, the 'selected role' will
				be given through a $_GET variable. Note that /Dashboard/$1, $1 == 'page'.

				In this case, CPM == 'Credits Per Month'.
			*/

			$selected_role = isset($_GET['page']) ? $_GET['page'] : '';
			$selected_role = in_array($selected_role, array_keys($Application['User']['multiple_role_metrics'])) ? $selected_role : '';

			$override_results = null;

			if (!empty($selected_role)) {
				$override_results = $Application['User']['multiple_role_metrics'][$selected_role]['Results'];
			}

			$data= $Application['User']['Results'];
			$ytd=0;
			$lifetime=0;
			$monthly='';
			$metrics='';
			$min=0;
			$max=100;
			$color="#CCCCC";
			$txt="";
			$dollar="";
			$excellence=0;
			$aryCredits=$Application['User']['Credits'];
			$training='';

			for($i=0; $i<12; $i++)
			{

				$period=mktime(0,0,0,4+$i,1,2017);
				if(isset($aryCredits[date("M-Y", $period)]))
				{
					$ytd=$aryCredits[date("M-Y", $period)]['ytd'];

					$monthly.=(empty($monthly) ? '' : ',') . "['" . date("M", $period) . "'," . $aryCredits[date("M-Y", $period)]['mtd'] . "]";
				}
				else
				{
					$monthly.=(empty($monthly) ? '' : ',') . "['" . date("M", $period) . "',0]";

				}
				if (isset($data[date("M-Y", $period)]))
				{
					$lifetime=(isset($data[date("M-Y", $period)]['lifetime']) ? $data[date("M-Y", $period)]['lifetime'] : $data[date("M-Y", $period)]['credit_mtd']);
					$excellence=$data[date("M-Y", $period)]['excellence'];
				}

			}

			/* If a specific role was chosen (multi-role) then use that abbreviation instead */
			$abbr = is_null($override_results) ? strtoupper($Application['User']['position']) : nissan_get_abbr_from_table_name($selected_role);

			/* If a specific role was selected (multi-role) then use that data instead of default. */
			$data= is_null($override_results) ? $Application['User']['Results'] : $override_results;

			switch ($abbr)
			{
				case 'R':	// Retail Sales Consultant
				case 'F':	// Fleet Sales Consultant
				case 'FM':	// Fleet Sales Manager
					$new=$sr=$fu='';
					$mm='';
					$dollar='<tr class="active">
							  <td align="center">$500</td>
							  <td align="center">$1000</td>
							  <td align="center">$1500</td>
							  <td align="center">$2000</td>
							</tr>';
					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						if(isset($data[date("M-Y", $period)]))
						{
								$new.=(empty($new)
									  ? '{ label: \'New Vehicle Sales\', backgroundColor: window.chartColors.black, data:['
									  : ',') . $data[date("M-Y", $period)]['credit_actual_sales'];
								$sr.=(empty($sr)
									   ? '{ label: \'Sales Recommendation R6M\', backgroundColor: window.chartColors.darkgrey, data:['
									   : ',') . $data[date("M-Y", $period)]['ce_recommendation'];
								$fu.=(empty($fu)
									  ? '{ label: \'Follow Up Saturation R6M\', backgroundColor: window.chartColors.midgrey, data:['
									  : ',') . $data[date("M-Y", $period)]['follow_up_credit'];
                                $training.=(empty($training)
      								  ? '{ label: \'Training\', backgroundColor: window.chartColors.lightred, data:['
      								  : ',') . ($data[date("M-Y", $period)]['training'] + $data[date("M-Y", $period)]['pathway'] + $data[date("M-Y", $period)]['classroom']);
						}
						else
						{
								$new.=(empty($new)
									  ? '{ label: \'New Vehicle Sales\', backgroundColor: window.chartColors.black, data:['
									  : ',') . '0';
								$sr.=(empty($sr)
									   ? '{ label: \'Sales Recommendation R6M\', backgroundColor: window.chartColors.darkgrey, data:['
									   : ',') . '0';
								$fu.=(empty($fu)
									  ? '{ label: \'Follow Up Saturation R6M\', backgroundColor: window.chartColors.midgrey, data:['
									  : ',') . '0';
                                $training.=(empty($training)
      								  ? '{ label: \'Training\', backgroundColor: window.chartColors.lightred, data:['
      								  : ',') . '0';
						}
					}
					$new.=']}';
					$sr.=']}';
					$fu.=']}';
					$training.=']}';
					$metrics=$new . ',' . $sr . ',' . $fu . ',' . $training;


					/* Status Level Thresholds */
					$CONSUL = 12000;
					$DIPLOMAT = 22000;
					$AMBASSADOR = 27000;
					$PREMIER = 38000;

					$min=0;
					$max=50000;

					$gage_indicators = "";
					$gage_indicators .= "generateGageIndicator('g1', " . ($CONSUL / $max) * 100 . ", '#525357', 'Consul');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($DIPLOMAT / $max) * 100 . ", '#BC2628', 'Diplomat');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($AMBASSADOR / $max) * 100 . ", '#546E22', 'Ambassador');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($PREMIER / $max) * 100 . ", '#B47C37', 'Premier');";

					if ( $ytd>= $PREMIER) {
						//	Premier
							$color='#B47C37';
						$txt='';
					} elseif ($ytd>=$AMBASSADOR) {
						//	Ambassador
						// $min=6000;
						$color='#546E22';
						$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($PREMIER-$ytd,0) . '</span> credits to reach Premier level';
						break;
					} elseif ($ytd >=$DIPLOMAT) {
						//	Diplomat
						// $min=11000;
							$color='#BC2628';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($AMBASSADOR-$ytd,0) . '</span> credits to reach Ambassador level';
						break;
					} elseif ($ytd >= $CONSUL) {
						//	Consul
							$color='#525357';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($DIPLOMAT-$ytd,0) . '</span> credits to reach Diplomat level';
							break;
					} else {
							//$min=$ytd;
							$color='#000';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($CONSUL-$ytd,0) . '</span> credits to reach Consul level';
						break;
					}


					break;

				case 'M':	// Sales Manager
					$ow=$new=$dl=$fu='';
					$mm='';
					$dollar='<tr class="active">
							  <td align="center">$500</td>
							  <td align="center">$1000</td>
							  <td align="center">$1500</td>
							  <td align="center">$2000</td>
							</tr>';
					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						if(isset($data[date("M-Y", $period)]))
						{
								$ow.=(empty($ow)
									  ? '{ label: \'Matched OW\', backgroundColor: window.chartColors.black, data:['
									  : ',') . $data[date("M-Y", $period)]['order_write_credit'];
								$new.=(empty($new)
									   ? '{ label: \'New Vehicle Sales\', backgroundColor: window.chartColors.darkgrey, data:['
									   : ',') . $data[date("M-Y", $period)]['actual_sales'];
								$fu.=(empty($fu)
									  ? '{ label: \'Follow Up %\', backgroundColor: window.chartColors.midgrey, data:['
									  : ',') . $data[date("M-Y", $period)]['follow_up_ce'];
								$dl.=(empty($dl)
									  ? '{ label: \'Dlr Rec\', backgroundColor: window.chartColors.lowred, data:['
									  : ',') . $data[date("M-Y", $period)]['ce_recomendation'];
								$mm.=(empty($mm)
									  ? '{ label: \'Mid Mth\', backgroundColor: window.chartColors.lightgrey, data:['
									  : ',') . $data[date("M-Y", $period)]['retail_midmth'];
                                $training.=(empty($training)
      								  ? '{ label: \'Training\', backgroundColor: window.chartColors.lightred, data:['
      								  : ',') . ($data[date("M-Y", $period)]['training'] + $data[date("M-Y", $period)]['pathway'] + $data[date("M-Y", $period)]['classroom']);
						}
						else
						{
								$ow.=(empty($ow)
									  ? '{ label: \'Matched OW\', backgroundColor: window.chartColors.black, data:['
									  : ',') . '0';
								$new.=(empty($new)
									   ? '{ label: \'New Vehicle Sales\', backgroundColor: window.chartColors.darkgrey, data:['
									   : ',') . '0';
								$fu.=(empty($fu)
									  ? '{ label: \'Follow Up %\', backgroundColor: window.chartColors.midgrey, data:['
									  : ',') . '0';
								$dl.=(empty($dl)
									  ? '{ label: \'Dlr Rec\', backgroundColor: window.chartColors.lowred, data:['
									  : ',') . '0';
								$mm.=(empty($mm)
									  ? '{ label: \'Mid Mth\', backgroundColor: window.chartColors.lightgrey, data:['
									  : ',') . '0';
                                $training.=(empty($training)
      								  ? '{ label: \'Training\', backgroundColor: window.chartColors.lightred, data:['
      								  : ',') . '0';
						}
					}
					$ow.=']}';
					$new.=']}';
					$dl.=']}';
					$fu.=']}';
					$mm.=']}';
					$training.=']}';
					$metrics=$ow . ',' . $new . ',' . $dl . ',' . $fu . ',' . $mm . ',' . $training;


					/* Status Level Thresholds */
					$CONSUL = 12000;
					$DIPLOMAT = 22000;
					$AMBASSADOR = 27000;
					$PREMIER = 38000;

					$min=0;
					$max=50000;

					$gage_indicators = "";
					$gage_indicators .= "generateGageIndicator('g1', " . ($CONSUL / $max) * 100 . ", '#525357', 'Consul');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($DIPLOMAT / $max) * 100 . ", '#BC2628', 'Diplomat');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($AMBASSADOR / $max) * 100 . ", '#546E22', 'Ambassador');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($PREMIER / $max) * 100 . ", '#B47C37', 'Premier');";

					if ( $ytd>= $PREMIER) {
						//	Premier
							$color='#B47C37';
						$txt='';
					} elseif ($ytd>=$AMBASSADOR) {
						//	Ambassador
						// $min=6000;
						$color='#546E22';
						$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($PREMIER-$ytd,0) . '</span> credits to reach Premier level';
						break;
					} elseif ($ytd >=$DIPLOMAT) {
						//	Diplomat
						// $min=11000;
							$color='#BC2628';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($AMBASSADOR-$ytd,0) . '</span> credits to reach Ambassador level';
						break;
					} elseif ($ytd >= $CONSUL) {
						//	Consul
							$color='#525357';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($DIPLOMAT-$ytd,0) . '</span> credits to reach Diplomat level';
							break;
					} else {
							//$min=$ytd;
							$color='#000';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($CONSUL-$ytd,0) . '</span> credits to reach Consul level';
						break;
					}

					break;

				case 'SA':	// Service Advisors
					$recommendation=$advice=$fu=$emw='';
					$mm='';
					$dollar='<tr class="active">
							  <td align="center">$150</td>
							  <td align="center">$400</td>
							  <td align="center">$1000</td>
							  <td align="center">$1500</td>
							</tr>';
					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						if(isset($data[date("M-Y", $period)]))
						{
								$recommendation.=(empty($recommendation)
									  ? '{ label: \'Service Recommendation\', backgroundColor: window.chartColors.black, data:['
									  : ',') . $data[date("M-Y", $period)]['recom_credit'];
								$advice.=(empty($advice)
									   ? '{ label: \'Advice\', backgroundColor: window.chartColors.darkgrey, data:['
									   : ',') . $data[date("M-Y", $period)]['trust_credit'];
								$fu.=(empty($fu)
									  ? '{ label: \'Vehicle Cleanliness\', backgroundColor: window.chartColors.midgrey, data:['
									  : ',') . $data[date("M-Y", $period)]['fu_credit'];
								$emw.=(empty($emw)
									  ? '{ label: \'EMW\', backgroundColor: window.chartColors.lowred, data:['
									  : ',') . $data[date("M-Y", $period)]['emw_credit'];
                                $training.=(empty($training)
      								  ? '{ label: \'Training\', backgroundColor: window.chartColors.lightred, data:['
      								  : ',') . ($data[date("M-Y", $period)]['training'] + $data[date("M-Y", $period)]['pathway'] + $data[date("M-Y", $period)]['classroom']);
						}
						else
						{
								$recommendation.=(empty($recommendation)
									  ? '{ label: \'Service Recommendation\', backgroundColor: window.chartColors.black, data:['
									  : ',') . '0';
								$advice.=(empty($advice)
									   ? '{ label: \'Advice\', backgroundColor: window.chartColors.darkgrey, data:['
									   : ',') . '0';
								$fu.=(empty($fu)
									  ? '{ label: \'% Follow Up\', backgroundColor: window.chartColors.midgrey, data:['
									  : ',') . '0';
								$emw.=(empty($emw)
									  ? '{ label: \'EMW\', backgroundColor: window.chartColors.lowred, data:['
									  : ',') . '0';
                                $training.=(empty($training)
      								  ? '{ label: \'Training\', backgroundColor: window.chartColors.lightred, data:['
      								  : ',') . '0';
						}
					}
					$recommendation.=']}';
					$advice.=']}';
					$fu.=']}';
					$emw.=']}';
					$training.=']}';
					$metrics=$recommendation . ',' . $advice . ',' . $fu . ',' . $emw . ',' . $training;

					/* Status Level Thresholds */
					$CONSUL = 7000;
					$DIPLOMAT = 13000;
					$AMBASSADOR = 22000;
					$PREMIER = 33000;

					$min=0;
					$max=40000;

					$gage_indicators = "";
					$gage_indicators .= "generateGageIndicator('g1', " . ($CONSUL / $max) * 100 . ", '#525357', 'Consul');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($DIPLOMAT / $max) * 100 . ", '#BC2628', 'Diplomat');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($AMBASSADOR / $max) * 100 . ", '#546E22', 'Ambassador');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($PREMIER / $max) * 100 . ", '#B47C37', 'Premier');";

					if ( $ytd>= $PREMIER) {
						//	Premier
							$color='#B47C37';
						$txt='';
					} elseif ($ytd>=$AMBASSADOR) {
						//	Ambassador
						// $min=6000;
						$color='#546E22';
						$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($PREMIER-$ytd,0) . '</span> credits to reach Premier level';
						break;
					} elseif ($ytd >=$DIPLOMAT) {
						//	Diplomat
						// $min=11000;
							$color='#BC2628';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($AMBASSADOR-$ytd,0) . '</span> credits to reach Ambassador level';
						break;
					} elseif ($ytd >= $CONSUL) {
						//	Consul
							$color='#525357';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($DIPLOMAT-$ytd,0) . '</span> credits to reach Diplomat level';
							break;
					} else {
							//$min=$ytd;
							$color='#000';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($CONSUL-$ytd,0) . '</span> credits to reach Consul level';
						break;
					}

					break;

				case 'I':
					$nfsa=$ins=$emw=$penetration=$fu='';
					$dollar='<tr class="active">
							  <td align="center">$300</td>
							  <td align="center">$600</td>
							  <td align="center">$1000</td>
							  <td align="center">$1500</td>
							</tr>';
					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						if(isset($data[date("M-Y", $period)]))
						{
								$nfsa.=(empty($nfsa)
									  ? '{ label: \'NFSA Contracts\', backgroundColor: window.chartColors.black, data:['
									  : ',') . $data[date("M-Y", $period)]['credit_actual_sales'];
								$ins.=(empty($ins)
									  ? '{ label: \'Insurance\', backgroundColor: window.chartColors.darkgrey, data:['
									  : ',') . ($data[date("M-Y", $period)]['credits_mvi'] + $data[date("M-Y", $period)]['credits_vpi'] + $data[date("M-Y", $period)]['credits_pkg']);
								$emw.=(empty($emw)
									  ? '{ label: \'EMW Genuine/Extended\', backgroundColor: window.chartColors.midgrey, data:['
									  : ',') . $data[date("M-Y", $period)]['credits_emw'];
								$penetration.=(empty($penetration)
									  ? '{ label: \'Sales Penetration\', backgroundColor: window.chartColors.lowred, data:['
									  : ',') . $data[date("M-Y", $period)]['credits_penetration'];
								$fu.=(empty($fu)
									  ? '{ label: \'Follow Up\', backgroundColor: window.chartColors.lightgrey, data:['
									  : ',') . $data[date("M-Y", $period)]['credits_fi'];
						}
						else
						{
								$nfsa.=(empty($nfsa)
									  ? '{ label: \'NFSA Contracts\', backgroundColor: window.chartColors.black, data:['
									  : ',') . '0';
								$ins.=(empty($ins)
									  ? '{ label: \'Insurance\', backgroundColor: window.chartColors.darkgrey, data:['
									  : ',') . '0';
								$emw.=(empty($emw)
									  ? '{ label: \'EMW Genuine/Extended\', backgroundColor: window.chartColors.midgrey, data:['
									  : ',') . '0';
								$penetration.=(empty($penetration)
									  ? '{ label: \'Sales Penetration\', backgroundColor: window.chartColors.lowred, data:['
									  : ',') . '0';
								$fu.=(empty($fu)
									  ? '{ label: \'Follow Up\', backgroundColor: window.chartColors.lightgrey, data:['
									  : ',') . '0';
						}
					}
					$nfsa.=']}';
					$ins.=']}';
					$emw.=']}';
					$penetration.=']}';
					$fu.=']}';
					$metrics=$nfsa . ',' . $ins . ',' . $emw . ',' . $penetration . ',' . $fu;

					/* Status Level Thresholds */
					$CONSUL = 11000;
					$DIPLOMAT = 25000;
					$AMBASSADOR = 30000;
					$PREMIER = 50000;

					$min=0;
					$max=60000;

					$gage_indicators = "";
					$gage_indicators .= "generateGageIndicator('g1', " . ($CONSUL / $max) * 100 . ", '#525357', 'Consul');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($DIPLOMAT / $max) * 100 . ", '#BC2628', 'Diplomat');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($AMBASSADOR / $max) * 100 . ", '#546E22', 'Ambassador');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($PREMIER / $max) * 100 . ", '#B47C37', 'Premier');";

					if ( $ytd>= $PREMIER) {
						//	Premier
							$color='#B47C37';
						$txt='';
					} elseif ($ytd>=$AMBASSADOR) {
						//	Ambassador
						// $min=6000;
						$color='#546E22';
						$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($PREMIER-$ytd,0) . '</span> credits to reach Premier level';
						break;
					} elseif ($ytd >=$DIPLOMAT) {
						//	Diplomat
						// $min=11000;
							$color='#BC2628';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($AMBASSADOR-$ytd,0) . '</span> credits to reach Ambassador level';
						break;
					} elseif ($ytd >= $CONSUL) {
						//	Consul
							$color='#525357';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($DIPLOMAT-$ytd,0) . '</span> credits to reach Diplomat level';
							break;
					} else {
							//$min=$ytd;
							$color='#000';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($CONSUL-$ytd,0) . '</span> credits to reach Consul level';
						break;
					}

					break;

                // Stock Controller
				case 'SC':
					$stock=$ow=$retail=$matched=$davo='';
					$dollar='<tr class="active">
							  <td align="center">$150</td>
							  <td align="center">$400</td>
							  <td align="center">$1000</td>
							  <td align="center">$1500</td>
							</tr>';
					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						if(isset($data[date("M-Y", $period)]))
						{
								$stock.=(empty($stock)
									  ? '{ label: \'Stock Cover\', backgroundColor: window.chartColors.black, data:['
									  : ',') . $data[date("M-Y", $period)]['stock_credit'];
								$ow.=(empty($ow)
									  ? '{ label: \'OW Data Entry\', backgroundColor: window.chartColors.darkgrey, data:['
									  : ',') . $data[date("M-Y", $period)]['ow_credit'];
								$retail.=(empty($retail)
									  ? '{ label: \'Retail % Mid Mth\', backgroundColor: window.chartColors.midgrey, data:['
									  : ',') . $data[date("M-Y", $period)]['retail_credit'];
								$matched.=(empty($matched)
									  ? '{ label: \'OW Compliance\', backgroundColor: window.chartColors.lowred, data:['
									  : ',') . $data[date("M-Y", $period)]['matched_credit'];
								$davo.=(empty($davo)
									  ? '{ label: \'Davo\', backgroundColor: window.chartColors.lightgrey, data:['
									  : ',') . $data[date("M-Y", $period)]['davo_credit'];
                                $training.=(empty($training)
      								  ? '{ label: \'Training\', backgroundColor: window.chartColors.lightred, data:['
      								  : ',') . ($data[date("M-Y", $period)]['training'] + $data[date("M-Y", $period)]['pathway'] + $data[date("M-Y", $period)]['classroom']);
						}
						else
						{
								$stock.=(empty($stock)
									  ? '{ label: \'Stock Cover\', backgroundColor: window.chartColors.black, data:['
									  : ',') . '0';
								$ow.=(empty($ow)
									  ? '{ label: \'OW Data Entry\', backgroundColor: window.chartColors.darkgrey, data:['
									  : ',') . '0';
								$retail.=(empty($retail)
									  ? '{ label: \'Retail % Mid Mth\', backgroundColor: window.chartColors.midgrey, data:['
									  : ',') . '0';
								$matched.=(empty($matched)
									  ? '{ label: \'OW Compliance\', backgroundColor: window.chartColors.lowred, data:['
									  : ',') . '0';
								$davo.=(empty($davo)
									  ? '{ label: \'Davo\', backgroundColor: window.chartColors.lightgrey, data:['
									  : ',') . '0';
                                $training.=(empty($training)
      								  ? '{ label: \'Training\', backgroundColor: window.chartColors.lightred, data:['
      								  : ',') . '0';
						}
					}
					$stock.=']}';
					$ow.=']}';
					$retail.=']}';
					$matched.=']}';
					$davo.=']}';
					$training.=']}';
					$metrics=$stock . ',' . $ow . ',' . $retail . ',' . $matched . ',' . $davo . ',' . $training;

					/* Status Level Thresholds */
					$CONSUL = 9000;
					$DIPLOMAT = 12000;
					$AMBASSADOR = 16000;
					$PREMIER = 22000;

					$min=0;
					$max=30000;

					$gage_indicators = "";
					$gage_indicators .= "generateGageIndicator('g1', " . ($CONSUL / $max) * 100 . ", '#525357', 'Consul');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($DIPLOMAT / $max) * 100 . ", '#BC2628', 'Diplomat');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($AMBASSADOR / $max) * 100 . ", '#546E22', 'Ambassador');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($PREMIER / $max) * 100 . ", '#B47C37', 'Premier');";

					if ( $ytd>= $PREMIER) {
						//	Premier
							$color='#B47C37';
						$txt='';
					} elseif ($ytd>=$AMBASSADOR) {
						//	Ambassador
						// $min=6000;
						$color='#546E22';
						$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($PREMIER-$ytd,0) . '</span> credits to reach Premier level';
						break;
					} elseif ($ytd >=$DIPLOMAT) {
						//	Diplomat
						// $min=11000;
							$color='#BC2628';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($AMBASSADOR-$ytd,0) . '</span> credits to reach Ambassador level';
						break;
					} elseif ($ytd >= $CONSUL) {
						//	Consul
							$color='#525357';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($DIPLOMAT-$ytd,0) . '</span> credits to reach Diplomat level';
							break;
					} else {
							//$min=$ytd;
							$color='#000';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($CONSUL-$ytd,0) . '</span> credits to reach Consul level';
						break;
					}

					break;

				case 'C':
					$freq=$ontime=$balance=$quality=$checklist=$meetings='';
					$dollar='<tr class="active">
							  <td align="center">$300</td>
							  <td align="center">$600</td>
							  <td align="center">$1000</td>
							  <td align="center">$1500</td>
							</tr>';
					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						if(isset($data[date("M-Y", $period)]))
						{
								$freq.=(empty($freq)
									  ? '{ label: \'Frequency\', backgroundColor: window.chartColors.black, data:['
									  : ',') . $data[date("M-Y", $period)]['frequency_credits'];
								$ontime.=(empty($ontime)
									  ? '{ label: \'Ontime\', backgroundColor: window.chartColors.darkgrey, data:['
									  : ',') . $data[date("M-Y", $period)]['ontime_credits'];
								$balance.=(empty($balance)
									  ? '{ label: \'Balance\', backgroundColor: window.chartColors.midgrey, data:['
									  : ',') . $data[date("M-Y", $period)]['balance_credit'];
								$quality.=(empty($quality)
									  ? '{ label: \'Quality\', backgroundColor: window.chartColors.lowred, data:['
									  : ',') . $data[date("M-Y", $period)]['quality_credit'];
								$checklist.=(empty($checklist)
									  ? '{ label: \'Checklist\', backgroundColor: window.chartColors.lightgrey, data:['
									  : ',') . $data[date("M-Y", $period)]['checklist_credit'];
								$meetings.=(empty($meetings)
									  ? '{ label: \'Meetings\', backgroundColor: window.chartColors.gainsboro, data:['
									  : ',') . $data[date("M-Y", $period)]['meeting_credit'];
                                $training.=(empty($training)
      								  ? '{ label: \'Training\', backgroundColor: window.chartColors.lightred, data:['
      								  : ',') . ($data[date("M-Y", $period)]['training'] + $data[date("M-Y", $period)]['pathway'] + $data[date("M-Y", $period)]['classroom']);
					}
						else
						{
								$freq.=(empty($freq)
									  ? '{ label: \'Frequency\', backgroundColor: window.chartColors.black, data:['
									  : ',') . '0';
								$ontime.=(empty($ontime)
									  ? '{ label: \'Ontime\', backgroundColor: window.chartColors.darkgrey, data:['
									  : ',') . '0';
								$balance.=(empty($balance)
									  ? '{ label: \'Balance\', backgroundColor: window.chartColors.midgrey, data:['
									  : ',') . '0';
								$quality.=(empty($quality)
									  ? '{ label: \'Quality\', backgroundColor: window.chartColors.lowred, data:['
									  : ',') . '0';
								$checklist.=(empty($checklist)
									  ? '{ label: \'Checklist\', backgroundColor: window.chartColors.lightgrey, data:['
									  : ',') . '0';
								$meetings.=(empty($meetings)
									  ? '{ label: \'Meetings\', backgroundColor: window.chartColors.gainsboro, data:['
									  : ',') . '0';
                                $training.=(empty($training)
      								  ? '{ label: \'Training\', backgroundColor: window.chartColors.lightred, data:['
      								  : ',') . '0';
						}
					}
					$freq.=']}';
					$ontime.=']}';
					$balance.=']}';
					$quality.=']}';
					$checklist.=']}';
					$meetings.=']}';
					$training.=']}';
					$metrics=$freq . ',' . $ontime . ',' . $balance . ',' . $quality . ',' . $checklist . ',' . $meetings . ',' . $training;

					/* Status Level Thresholds */
					$CONSUL = 9000;
					$DIPLOMAT = 12000;
					$AMBASSADOR = 16000;
					$PREMIER = 20000;

					$min=0;
					$max=30000;

					$gage_indicators = "";
					$gage_indicators .= "generateGageIndicator('g1', " . ($CONSUL / $max) * 100 . ", '#525357', 'Consul');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($DIPLOMAT / $max) * 100 . ", '#BC2628', 'Diplomat');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($AMBASSADOR / $max) * 100 . ", '#546E22', 'Ambassador');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($PREMIER / $max) * 100 . ", '#B47C37', 'Premier');";

					if ( $ytd>= $PREMIER) {
						//	Premier
							$color='#B47C37';
						$txt='';
					} elseif ($ytd>=$AMBASSADOR) {
						//	Ambassador
						// $min=6000;
						$color='#546E22';
						$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($PREMIER-$ytd,0) . '</span> credits to reach Premier level';
						break;
					} elseif ($ytd >=$DIPLOMAT) {
						//	Diplomat
						// $min=11000;
							$color='#BC2628';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($AMBASSADOR-$ytd,0) . '</span> credits to reach Ambassador level';
						break;
					} elseif ($ytd >= $CONSUL) {
						//	Consul
							$color='#525357';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($DIPLOMAT-$ytd,0) . '</span> credits to reach Diplomat level';
							break;
					} else {
							//$min=$ytd;
							$color='#000';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($CONSUL-$ytd,0) . '</span> credits to reach Consul level';
						break;
					}

					break;

				case 'PM':
					$grp=$gas='';
					$dollar='<tr class="active">
							  <td align="center">$150</td>
							  <td align="center">$400</td>
							  <td align="center">$1000</td>
							  <td align="center">$1500</td>
							</tr>';
					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						if(isset($data[date("M-Y", $period)]))
						{
								$grp.=(empty($grp)
									  ? '{ label: \'GENUINE REPLACEMENT PARTS\', backgroundColor: window.chartColors.black, data:['
									  : ',') . $data[date("M-Y", $period)]['grp_credit'];
								$gas.=(empty($gas)
									  ? '{ label: \'GENUINE ACCESSORIES\', backgroundColor: window.chartColors.darkgrey, data:['
									  : ',') . $data[date("M-Y", $period)]['gas_credit'];
                                $training.=(empty($training)
      								  ? '{ label: \'TRAINING\', backgroundColor: window.chartColors.lightred, data:['
      								  : ',') . ($data[date("M-Y", $period)]['training'] + $data[date("M-Y", $period)]['pathway'] + $data[date("M-Y", $period)]['classroom']);
					}
						else
						{
								$grp.=(empty($grp)
									  ? '{ label: \'GENUINE REPLACEMENT PARTS\', backgroundColor: window.chartColors.black, data:['
									  : ',') . '0';
								$gas.=(empty($gas)
									  ? '{ label: \'GENUINE ACCESSORIES\', backgroundColor: window.chartColors.darkgrey, data:['
									  : ',') . '0';
                                $training.=(empty($training)
            						  ? '{ label: \'TRAINING\', backgroundColor: window.chartColors.lightred, data:['
            						  : ',') . '0';
						}
					}
					$grp.=']}';
					$gas.=']}';
					$training.=']}';
					$metrics=$grp . ',' . $gas . ',' . $training;

					// $min=7000;
					/* Status Level Thresholds */
					$CONSUL = 7000;
					$DIPLOMAT = 13000;
					$AMBASSADOR = 22000;
					$PREMIER = 33000;

					$min=0;
					$max=40000;

					$gage_indicators = "";
					$gage_indicators .= "generateGageIndicator('g1', " . ($CONSUL / $max) * 100 . ", '#525357', 'Consul');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($DIPLOMAT / $max) * 100 . ", '#BC2628', 'Diplomat');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($AMBASSADOR / $max) * 100 . ", '#546E22', 'Ambassador');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($PREMIER / $max) * 100 . ", '#B47C37', 'Premier');";

					if ( $ytd>= $PREMIER) {
						//	Premier
							$color='#B47C37';
						$txt='';
					} elseif ($ytd>=$AMBASSADOR) {
						//	Ambassador
						// $min=6000;
						$color='#546E22';
						$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($PREMIER-$ytd,0) . '</span> credits to reach Premier level';
						break;
					} elseif ($ytd >=$DIPLOMAT) {
						//	Diplomat
						// $min=11000;
							$color='#BC2628';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($AMBASSADOR-$ytd,0) . '</span> credits to reach Ambassador level';
						break;
					} elseif ($ytd >= $CONSUL) {
						//	Consul
							$color='#525357';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($DIPLOMAT-$ytd,0) . '</span> credits to reach Diplomat level';
							break;
					} else {
							//$min=$ytd;
							$color='#000';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($CONSUL-$ytd,0) . '</span> credits to reach Consul level';
						break;
					}

					break;

				case 'PS':
					$grp='';
					$dollar='<tr class="active">
							  <td align="center">$150</td>
							  <td align="center">$400</td>
							  <td align="center">$1000</td>
							  <td align="center">$1500</td>
							</tr>';
					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						if(isset($data[date("M-Y", $period)]))
						{
								$grp.=(empty($grp)
									  ? '{ label: \'GENUINE REPLACEMENT PARTS\', backgroundColor: window.chartColors.black, data:['
									  : ',') . $data[date("M-Y", $period)]['grp_credit'];
                                $training.=(empty($training)
      								  ? '{ label: \'TRAINING\', backgroundColor: window.chartColors.lightred, data:['
      								  : ',') . ($data[date("M-Y", $period)]['training'] + $data[date("M-Y", $period)]['pathway'] + $data[date("M-Y", $period)]['classroom']);
					}
						else
						{
								$grp.=(empty($grp)
									  ? '{ label: \'GENUINE REPLACEMENT PARTS\', backgroundColor: window.chartColors.black, data:['
									  : ',') . '0';
                               $training.=(empty($training)
      								  ? '{ label: \'TRAINING\', backgroundColor: window.chartColors.lightred, data:['
      								  : ',') . '0';
						}
					}
					$grp.=']}';
					$training.=']}';
					$metrics=$grp . ',' . $training;

					/* Status Level Thresholds */
					$CONSUL = 7000;
					$DIPLOMAT = 13000;
					$AMBASSADOR = 22000;
					$PREMIER = 33000;

					$min=0;
					$max=40000;

					$gage_indicators = "";
					$gage_indicators .= "generateGageIndicator('g1', " . ($CONSUL / $max) * 100 . ", '#525357', 'Consul');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($DIPLOMAT / $max) * 100 . ", '#BC2628', 'Diplomat');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($AMBASSADOR / $max) * 100 . ", '#546E22', 'Ambassador');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($PREMIER / $max) * 100 . ", '#B47C37', 'Premier');";

					if ( $ytd>= $PREMIER) {
						//	Premier
							$color='#B47C37';
						$txt='';
					} elseif ($ytd>=$AMBASSADOR) {
						//	Ambassador
						// $min=6000;
						$color='#546E22';
						$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($PREMIER-$ytd,0) . '</span> credits to reach Premier level';
						break;
					} elseif ($ytd >=$DIPLOMAT) {
						//	Diplomat
						// $min=11000;
							$color='#BC2628';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($AMBASSADOR-$ytd,0) . '</span> credits to reach Ambassador level';
						break;
					} elseif ($ytd >= $CONSUL) {
						//	Consul
							$color='#525357';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($DIPLOMAT-$ytd,0) . '</span> credits to reach Diplomat level';
							break;
					} else {
							//$min=$ytd;
							$color='#000';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($CONSUL-$ytd,0) . '</span> credits to reach Consul level';
						break;
					}

					break;
				case 'SM':
					$recommendation=$clean=$fu=$emw='';
					$dollar='<tr class="active">
							  <td align="center">$150</td>
							  <td align="center">$400</td>
							  <td align="center">$1000</td>
							  <td align="center">$1500</td>
							</tr>';
					for($i=0; $i<12; $i++)
					{
						$period=mktime(0,0,0,4+$i,1,2017);
						if(isset($data[date("M-Y", $period)]))
						{
								$recommendation.=(empty($recommendation)
									  ? '{ label: \' SERVICE RECOMMENDATION\', backgroundColor: window.chartColors.black, data:['
									  : ',') . $data[date("M-Y", $period)]['recommendation_credit'];
								$clean.=(empty($clean)
									  ? '{ label: \' VEHICLE CLEANLINESS\', backgroundColor: window.chartColors.darkgrey, data:['
									  : ',') . $data[date("M-Y", $period)]['vclean_credit'];
								$fu.=(empty($fu)
									  ? '{ label: \'FOLLOW UP%\', backgroundColor: window.chartColors.midgrey, data:['
									  : ',') . $data[date("M-Y", $period)]['followup_credit'];
								$emw.=(empty($emw)
									  ? '{ label: \' EMW\', backgroundColor: window.chartColors.lowred, data:['
									  : ',') . $data[date("M-Y", $period)]['emw_credit'];
                                $training.=(empty($training)
      								  ? '{ label: \'TRAINING\', backgroundColor: window.chartColors.lightred, data:['
      								  : ',') . ($data[date("M-Y", $period)]['training'] + $data[date("M-Y", $period)]['pathway'] + $data[date("M-Y", $period)]['classroom']);
					}
						else
						{
								$recommendation.=(empty($recommendation)
									  ? '{ label: \' SERVICE RECOMMENDATION\', backgroundColor: window.chartColors.black, data:['
									  : ',') . '0';
								$clean.=(empty($clean)
									  ? '{ label: \' VEHICLE CLEANLINESS\', backgroundColor: window.chartColors.darkgrey, data:['
									  : ',') . '0';
								$fu.=(empty($fu)
									  ? '{ label: \'FOLLOW UP%\', backgroundColor: window.chartColors.midgrey, data:['
									  : ',') . '0';
								$emw.=(empty($emw)
									  ? '{ label: \' EMW\', backgroundColor: window.chartColors.lowred, data:['
									  : ',') . '0';
                                $training.=(empty($training)
      								  ? '{ label: \'TRAINING\', backgroundColor: window.chartColors.lightred, data:['
      								  : ',') . '0';
						}
					}
					$recommendation.=']}';
					$clean.=']}';
					$fu.=']}';
					$emw.=']}';
					$training.=']}';
					$metrics=$recommendation . "," . $clean . "," . $fu . "," . $emw . ',' . $training;

					/* Status Level Thresholds */
					$CONSUL = 7000;
					$DIPLOMAT = 13000;
					$AMBASSADOR = 22000;
					$PREMIER = 33000;

					$min=0;
					$max=40000;

					$gage_indicators = "";
					$gage_indicators .= "generateGageIndicator('g1', " . ($CONSUL / $max) * 100 . ", '#525357', 'Consul');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($DIPLOMAT / $max) * 100 . ", '#BC2628', 'Diplomat');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($AMBASSADOR / $max) * 100 . ", '#546E22', 'Ambassador');";
					$gage_indicators .= "generateGageIndicator('g1', " . ($PREMIER / $max) * 100 . ", '#B47C37', 'Premier');";

					if ( $ytd>= $PREMIER) {
						//	Premier
							$color='#B47C37';
						$txt='';
					} elseif ($ytd>=$AMBASSADOR) {
						//	Ambassador
						// $min=6000;
						$color='#546E22';
						$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($PREMIER-$ytd,0) . '</span> credits to reach Premier level';
						break;
					} elseif ($ytd >=$DIPLOMAT) {
						//	Diplomat
						// $min=11000;
							$color='#BC2628';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($AMBASSADOR-$ytd,0) . '</span> credits to reach Ambassador level';
						break;
					} elseif ($ytd >= $CONSUL) {
						//	Consul
							$color='#525357';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($DIPLOMAT-$ytd,0) . '</span> credits to reach Diplomat level';
							break;
					} else {
							//$min=$ytd;
							$color='#000';
							$txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format($CONSUL-$ytd,0) . '</span> credits to reach Consul level';
						break;
					}

					break;

			}

			/* Return data back to normal */
			$data= $Application['User']['Results'];

			$multipleRoleSelect = '';

			if (count($Application['User']['multiple_role_metrics']) > 1) {
				$multipleRoleSelect = '
					<div style="padding: 10px 0;">
						<strong>You have had multiple roles: </strong>
						<select id="metricsRoleSelect">
				';

				foreach ($Application['User']['positions'] as $position) {
					$selected = $position == $selected_role ? 'selected' : '';
					$multipleRoleSelect .= '<option ' . $selected . ' value="' . $position . '">' . nissan_get_role_from_table_name($position) . '</option>';
				}

				$multipleRoleSelect .= '</select>
				</div>';
			}

			$count=0;
			$class='';
			$leaderboard='';
			foreach ($Application['User']['Rankings'] as $row)
			{
				$class=($class=='active' ? '' : 'active');

				$leaderboard.='<tr class="' . $class . '">
								<td>' . $row['ranking'] . '</td>
								<td>' . ($row['member_id']==$Application['User']['employee_code']
										 ? '<a href="/Dashboard/Leaderboards" style="font-family: \'nissan_brandregular\';">'
										 : '') . $row['firstname'] . ' ' . $row['lastname'] .
										($row['member_id']==$Application['User']['employee_code']
										 ? '</a>'
										 : '') . '</td>
								<td>' . $row['company_name'] . '</td>
								<td>' . $row['company_state'] . '</td>
							  </tr>';
				$count++;
				if ($count>3)
				{
					break;
				}
			}
			if ($Application['User']['MyRanking']['ranking']>4)
			{
				$leaderboard.='<tr class="active">
                <td style="border-top:1px solid #FF0000;">' . $Application['User']['MyRanking']['ranking'] . '</td>
                <td style="border-top:1px solid #FF0000;"><a href="/Dashboard/Leaderboards" style="font-family: \'nissan_brandregular\';">' . $Application['User']['MyRanking']['firstname'] . ' ' . $Application['User']['MyRanking']['lastname'] . '</a></td>
                <td style="border-top:1px solid #FF0000;">' . $Application['User']['MyRanking']['company_name'] .'</td>
                <td style="border-top:1px solid #FF0000;">' . $Application['User']['MyRanking']['company_state'] . '</td>
              </tr>';


			}

			$ranking='';
			if ($Application['User']['position']=='R' ||
				$Application['User']['position']=='F' ||
				$Application['User']['position']=='M' ||
			    $Application['User']['position']=='FM')
			{

				$ranking='<td><span class="rank">' . (isset($Application['User']['MyRanking']['ranking']) ? fnord($Application['User']['MyRanking']['ranking']) : "N/A") . '</span><br>
						<p>Nationally</p></td>
						<td><span class="rank">' . (isset($Application['User']['Regional']) ? fnord($Application['User']['Regional']) : "N/A"). '</span><br>
						<p>Regionally</p></td>';
			}
			else
			{
				$ranking='<td colspan=2><span class="rank">' . fnord($Application['User']['MyRanking']['ranking']) . '</span><br>
						<p>Nationally</p></td>';
			}

			$events='';
			if ($database->NissanEvents())
			{
				foreach($database->Data as $evt)
				{
					$events.=(empty($events) ? "" : ",") . '{ 	title: "' . $evt['title'] . '",
																start: "' . date("Y-m-d", strtotime($evt['datestamp'])) . '"}';

				}
			}
			/*
				Determine if user has at least one row where the value for 'excellence'
				is 2000.
			*/
			$has_2000_excellence = false;
			foreach ($Application['User']['Results'] as $result_month) {
				if ($result_month["excellence"] == 2000) {
					$has_2000_excellence = true;
					break;
				}
			}

			/* Assume only a single/current role */
			$metricsIndResultsLink = "/Dashboard/Metrics";

			if ($override_results) {
				$metricsIndResultsLink = "/Dashboard/Metrics/" . $selected_role;
			}

			$content=read_template("dashboard-mydashboard.html", array(
																		"FIRSTNAME" => $Application['User']['firstname'] . ' - ' . $Application['User']['position_desc'],
																		"YTD" => number_format($ytd,0),
																		"YTD-CREDITS" =>$ytd,
																		"GAGE-INDICATORS" => $gage_indicators,
																		"STATUS-TEXT" => $txt,
																		"MIN-LEVEL" => $min,
																		"MAX-LEVEL" => $max,
																		"LEVEL-COLOR" => $color,
																		"LIFETIME" => number_format($lifetime,0),
																		"MONTHLY-CREDIT" => $monthly,
																		"METRICS" => $metrics,
																		"REGISTERED" => ($Application['User']['Registered']=='YES' ? '&#10004' : 'X'),
																		"REGISTERED-LINK" =>($Application['User']['Registered']=='YES' ? '<p style="color: #FFFFFF;">250 Credits Applied</p>' : '<a href="http://www.nissan-events.com.au/ac2017/reg" target="_blank">
            <button style="background-color:#c40030; width:100%; margin:0 auto; font-size:11px;" type="button" class="btn btn-primary btn-block">Register Now</button>
            </a>'),
																		"EXCELLENCE" => ($has_2000_excellence ? '&#10004' : 'X'),
																		"EXCELLENCE-TEXT" => ($has_2000_excellence ? '<p style="color: #FFFFFF;">2,000 Credits Applied</p>' : '<p style="color: #FFFFFF;">refer <a target="_blank" href="http://nissan-events.com.au/excellence-fy17/ac/welcome.html">Dealer Excellence overview</a></p>'),
																		"TRAINING-ONTRACK" => 'X',
																		"LEADERBOARD" => $leaderboard,
																		"RANKING" => $ranking,
																		"DOLLAR-REWARDS" => $dollar,
																		"EVENTS" => $events,
																		"MULTIPLE-ROLE-SELECT" => $multipleRoleSelect,
																		"METRICS-IND-RESULTS-LINK" => $metricsIndResultsLink
																		));
			break;
	}
?>
