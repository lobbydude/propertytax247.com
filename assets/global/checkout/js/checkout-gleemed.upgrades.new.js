var zcTimer = null;

function updateReportPrice(myIdx) {
	var rPrice = 0;
	var isComm = (jQuery('#commercial_' + myIdx + '_yes').attr('checked') == 'checked');
	var zc = (jQuery('#zc' + myIdx).val() == '0');
	var izc = (jQuery('#zc' + myIdx).val() == '2'); 
	var isRush = (jQuery('#rush_' + myIdx).attr('checked') == 'checked');
	
	if (isComm) {
		rPrice += 110;
		jQuery('#comm_msg_' + myIdx).show();
	} else {
		jQuery('#comm_msg_' + myIdx).hide();
	}
	
	if (izc) {
		jQuery('#zip_msg_' + myIdx).hide();
		jQuery('#zip_imsg_' + myIdx).show();
	} else {
		jQuery('#zip_imsg_' + myIdx).hide();
		if (zc) {
			rPrice += 75;
			jQuery('#zip_msg_' + myIdx).show();
		} else {
			jQuery('#zip_msg_' + myIdx).hide();
		}
	}
	
	if (isRush) {
		rPrice += 25;
	}
	
	if (rPrice > 0) {
		jQuery('#report_price_' + myIdx).show().find('span').html('+ $' + rPrice + '.00');		
	} else {
		jQuery('#report_price_' + myIdx).hide();
	}

	updatePrice();
}

function updatePrice() {
	if (jQuery('#orderTotal').length) {
		var myPrice = parseInt(jQuery('#nr option:selected').attr('rel'));
		
		jQuery('input.rush:checked').each(function() {
			myPrice += 25;
		});
		
		jQuery("input.comm_yes:checked").each(function() {
			myPrice += 110;			
		});
		
		var hasZc = false;
		
		jQuery(".zc").each(function() {
			if (jQuery(this).val() == '0') {
				myPrice += 75;
				hasZc = true;
			}
		});
		
		if (hasZc) {
//			jQuery('#zipMsg').show();
		} else {
//			jQuery('#zipMsg').hide();
		}
		
		jQuery('#orderTotal span').html('$' + myPrice.toFixed(2));
	}
}

function zcLookup(myVal, myRel) {
	if (myVal == '') {
		jQuery('#zc' + myRel).val(1);
		updateReportPrice(myRel);
		
		return false;
	}
	
	$.ajax('/zip-lookup.php?zip=' + myVal, {success: function(myRes) {
		jQuery('#zc' + myRel).val(myRes);
		updateReportPrice(myRel);
	}});
}

jQuery(document).ready(function() {
/*
	jQuery("#nr").change(function() {
		jQuery("#priceDiv").html('Order Total: ' + jQuery(this).find('option:selected').attr('rel'));
	});
	
	jQuery("#priceDiv").html('Order Total: ' + jQuery('#nr').find('option:selected').attr('rel'));
*/

	jQuery('.zip').blur(function() {
		var myVal = jQuery(this).val();
		var myRel = jQuery(this).attr('rel');

		if (zcTimer == null) {
			//
		} else {
			clearTimeout(zcTimer);
		}
		
		zcTimer = setTimeout('zcLookup(\'' + myVal + '\', \'' + myRel + '\')', 1000);
	});

	if (jQuery('#addAddressLink').length) {
		jQuery('#addAddressLink').click(function(e) {
			var numAddresses = parseInt(jQuery('#numAddresses').val());
			var maxAddresses = parseInt(jQuery("#maxAddresses").val());
			var rushStatus = parseInt(jQuery('#RUSH_STATUS').val());
			
			if (numAddresses < maxAddresses) {
				
				var newHtml = '<table  width="700" cellpadding="3" cellspacing="5" border=0><tr><td  align=left colspan=2><b>Address for Report #' + (numAddresses+1) + ':</b> &nbsp;<a class="tooltip" href="#">?<span class="ttclassic">You can submit an address you want a report on now, or do so later in the member\'s area after you complete your report credit order below.</span></a>';
				newHtml += '</td></tr>';
				
				newHtml += '<tr><td align="right"><label for="commercial_' + numAddresses + '_no">Residential Property</td><td colspan="2"><table cellspacing="0" width="100%"><tr><td style="width: 120px;"><input CHECKED class="comm_yn" id="commercial_' + numAddresses + '_no" name="commercial[' + numAddresses + ']" type="radio" value="0" rel="' + numAddresses + '" /><a class="tooltip" href="#">?<span class="ttclassic">Check this box if the property you are doing the report on is residential</i></span></a></td>';
				newHtml += '<td><label for="commercial_' + numAddresses + '_yes">Commercial Property</label> <input id="commercial_' + numAddresses + '_yes" name="commercial[' + numAddresses + ']" type="radio" value="1" rel="' + numAddresses + '" class="comm_yn comm_yes" /> <a class="tooltip" href="#">?<span class="ttclassic">Check this box if the property you are doing the report on is commercial</i></span></a></td>';
				newHtml += '<td valign="middle"><div class="report_price" id="report_price_' + numAddresses + '"><strong>This Address:</strong>&nbsp;<span style="color: green; font-size: 1.6em; font-weight: bold;"></span></div></td></tr></table></td></tr>';
				
				newHtml += '<tr><td align=right style="width: 150px;">Address & Street:</td><td align=left><input class="inputc addr" style="width: 260px;" name="addr[]" value=""> <a class="tooltip" href="#">?<span class="ttclassic">Please Put in the Street Address, City & Zip code for the property you want us to create the Title Report on.  For example:<BR><i>1234 Title St., West Palm Beach 33423</i></span></a></td><td rowspan="5" valign="top" style="width: 220px;"><div class="comm_msg" id="comm_msg_' + numAddresses + '">Commercial properties start at $165 because of their complexity and time to complete. After submitting the order we will email you with an estimate of turnaround time and any additional cost depending on the complexity of the case</div><div class="zip_msg" id="zip_msg_' + numAddresses + '">Reports for properties outside of our coverage fee are assessed a fee of an additional $75.00 each. Additional fees may be assessed and you will be notified if that is the case</div><div class="zip_msg" id="zip_imsg_' + numAddresses + '">You have entered an invalid zip code, please enter a 5 digit zip code with no spaces or letters</div></td></tr><tr><td align=right>Unit:</td><td align=left><input class="inputc addr" style="width: 51px;" name="units[]" value="" /> <a class="tooltip" href="#">?<span class="ttclassic">Please Put in the Street Address, City & Zip code for the property you want us to create the Title Report on.  For example:<BR><i>1234 Title St., West Palm Beach 33423</i></span></a></td></tr>';
				newHtml += '<tr><td align=right>City:</td><td align=left><input style="width: 102px;" class="inputc addr"  name="city[]" value="">';
				newHtml += ' State: <input class="inputc addr" size="2" name="state[]" value=""> Zip: <input class="inputc addr zip" style="width: 43px;" name="ozip[]" value="" rel="' + numAddresses + '"><input class="zc" type="hidden" id="zc' + numAddresses + '" name="zc" value="1" /> <a class="tooltip" href="#">?<span class="ttclassic">Please Put in the Street Address, City & Zip code for the property you want us to create the Title Report on.  For example:<BR><i>1234 Title St., West Palm Beach 33423</i></span></a></td>';
				newHtml += '</tr>';
				
								
				if (jQuery('#reseller').length) {
					newHtml += '<tr><td align=right>Cover Page Info for #' + (numAddresses+1) + ':</td><td><input class="inputc cinfo" size="50" name="cinfo[]" value=""></td></tr>';	
				}
				
				newHtml += '<tr><td align=right><a class="tooltip" href="#" style="margin: 0px; padding: 0px;">Additional Info:<span class="ttclassic">Any additional info about the report you wish to add such as when you need it by, owner name, parcel id or special instructions go here.</span></a></td>';
				newHtml += '<td align=left><input class="inputc ainfo" placeholder="case #, owner name, parcel/tax ID, special instructions" style="width: 260px;" name="ainfo[]" value="">&nbsp;';//<label for="fc_' + (numAddresses+1) + '"><input type="checkbox" id="fc_' + (numAddresses+1) + '" name="foreclosures[]" value="' + (numAddresses+1) + '" class="fcbox" />&nbsp;Foreclosure Auction</label> <a class="tooltip" href="#">?<span class="ttclassic">If this report is for an upcoming foreclosure auction check this box to add a case number and we will explain the lien effects on the auction property.</span></a> </td>';
//				newHtml += '</tr><tr id="casenum' + (numAddresses+1) + '" style="display: none;"><td align="right">Case Number:</td><td><input class="inputc casenum" style="width: 260px;" name="casenum[]" value="" /> ';
				newHtml += '<a class="tooltip" href="#">?<span class="ttclassic">Add the case number for a foreclosure property and we will explain in plain English on the report the auction data.</span></a> </td></tr>';
/*
				
				newHtml += '<tr><td align="right"><input type="checkbox" id="commercial_' + (numAddresses+1) + '" class="commercial" name="commercial[]" value="' + (numAddresses+1) + '" /></td>';
				newHtml += '<td><label for="commercial_' + (numAddresses+1) + '"><B>THIS IS A COMMERCIAL PROPERTY +24-48 hours and $100.00</b> <br> Additional time and payment may be required. </label>&nbsp;<a class="tooltip" href="#">?<span class="ttclassic">Additional cost and time may be required as commercial properties require more research. You will be notified if a report will take more then the additional 24-48 hours and $100.00 listed here.</span></a></td></tr>';
*/
				
				if (rushStatus == 1) {
				
				newHtml += '<tr><td align="right"><input type="checkbox" id="rush_' + numAddresses + '" class="rush" name="rush[]" value="' + numAddresses + '" rel="' + numAddresses + '" /></td><td style="font-size: .9em;"><label for="rush_' + numAddresses + '"><B>RUSH UPGRADE FOR THIS PROPERTY  +$25.00</b> <br> Guaranteed Same Day IF ordered by 3:00 PM M-F </label>&nbsp;<a class="tooltip" href="#">?<span class="ttclassic">If you select this upgrade your order will automatically be jumped ahead of other orders and will be completed same day if ordered by 3pm MON - FRI. Orders placed after 3PM EST will be delivered before 12pm the following business day.</span></a></td></tr>';
				
				/* newHtml += '<tr><td align="right"><input type="checkbox" id="rush_' + (numAddresses+1) + '" class="rush" name="rush[]" value="' + numAddresses + '" /></td><td><label for="rush_' + (numAddresses+1) + '"><B>RUSH UPGRADE FOR THIS PROPERTY  +$25.00</b> <br> Guaranteed Same Day IF ordered by 3:00 PM MON-FRI </label>&nbsp;<a class="tooltip" href="#">?<span class="ttclassic">If you select this upgrade your order will automatically be jumped ahead of other orders and will be completed same day if ordered by 3pm MON - FRI. Orders placed after 3PM EST will be delivered before 12pm the following business day.</span></a></td></tr>'; */
				} else {
				newHtml += '<tr><td align="right"><input DISABLED type="checkbox" id="rush_' + (numAddresses+1) + '" class="rush" name="rush[]" value="' + numAddresses + '" /></td><td><label for="rush_' + (numAddresses+1) + '"><B>RUSH UPGRADE FOR THIS PROPERTY  +$25.00</b> <br><span style="color: #FF0000;">Sold Out Today, Sorry!</span></label>&nbsp;</td></tr>';
					
				}
				newHtml += '</table>';
			
//			var newHtml = '<div id="address' + numAddresses + '" style="margin: 4px 0px;"><input size="50" type="text" id="addresses' + numAddresses + '" name="addresses[]" value="" />&nbsp;<input type="text" id="ainfo' + numAddresses + '" name="ainfo[]" value="" />&nbsp;<a href="#" rel="' + numAddresses + '" class="removeAddressLink">Remove</a></div>';

				jQuery('#addrContainer').append(newHtml);
				jQuery('#numAddresses').val((numAddresses+1));
			
				$(":input[placeholder]").placeholder();
			
				jQuery(".fcbox").unbind('click').click(function() {
					jQuery('#casenum' + jQuery(this).val()).toggle();
				});

			
//			jQuery('.removeAddressLink').unbind('click').click(function(e) {
//				jQuery('#address' + jQuery(this).attr('rel')).html('').hide();
//				e.preventDefault();
//			});
				if ((numAddresses+1) == maxAddresses) {
					jQuery("#addMore").hide();
				}
				
				jQuery('.comm_yn').unbind('click').click(function() {
		 var myIdx = jQuery(this).attr('rel'); 
		 
		 updateReportPrice(myIdx);
	  });
	  
	  jQuery('.rush').unbind('click').click(function() {
		 var myIdx = jQuery(this).attr('rel'); 
		 
 		 if ($('#zc' + myIdx).val() == '0') {
			 alert('Orders outside of our coverage area require a minimum of 48 hours, therefore they cannot be rushed.');
			 return false;
		 }

		 
		 updateReportPrice(myIdx);	 
	  });
				
				jQuery('.zip').unbind('blur').blur(function() {
					var myVal = jQuery(this).val();
					var myRel = jQuery(this).attr('rel');

					if (zcTimer == null) {
						//
					} else {
						clearTimeout(zcTimer);
					}
		
					zcTimer = setTimeout('zcLookup(\'' + myVal + '\', \'' + myRel + '\')', 1000);
				});
			}
			
			e.preventDefault();
		});
	}
	
	if (jQuery("input[name=do]").length) {
		var myVal = jQuery("input[name=do]:checked").val();
		
		if (myVal == 'order') {
			jQuery("#billing_order").show();
			jQuery("#billing_order_pp").hide();
		} else {
			jQuery("#billing_order").hide();
			jQuery("#billing_order_pp").show();		
		}
		
		jQuery("input[name=do]").click(function() {
			var myVal = jQuery(this).val();
		
			if (myVal == 'order') {
				jQuery("#billing_order").show();
				jQuery("#billing_order_pp").hide();
			} else {
				jQuery("#billing_order").hide();
				jQuery("#billing_order_pp").show();		
			}
		});
		//jQuery('#billing_' + jQuery("input[@name=do]:checked").val()).show();
	}
	
	jQuery("#nr").change(function() {
		var myAddrs = new Object();
		var myAinfo = new Object();
		
		var ii = 0;
		jQuery("input.addr").each(function() {
			myAddrs[ii] = jQuery(this).val();
			ii++;
		});

		var ii = 0;
		jQuery("input.ainfo").each(function() {
			myAinfo[ii] = jQuery(this).val();
			ii++;
		});

		//jQuery("#addrContainer").html('');
		
		var nr = jQuery(this).val();
		var ec = 0;
		
		if (jQuery('#ec').length) {
			ec = jQuery('#ec').val();
		}
		jQuery("#maxAddresses").val((parseInt(nr)+parseInt(ec)));

		if (nr > 1) {
			jQuery('#addMore').show();
		} else {
			jQuery('#addMore').hide();
		}
		//jQuery("#numAddresses").val(nr);
		return true;
		
		if (nr > 5) {
			nr = 5;
			
			jQuery('#addMore').show();
		} else {
			jQuery("#addMore").hide();
		}
		jQuery("#numAddresses").val(nr);

		var newHtml = '';
				
			s = '';
		
		for (ii = 0; ii < 1; ii++) {
			if (ii in myAddrs) {
				theVal = myAddrs[ii];
				theVal2 = myAinfo[ii];
			} else {
				theVal = '';
				theVal2 = '';
			}
			
//			var theVal = (myAddrs[ii].length ? '' : myAddrs[ii]);
			
				var newHtml = '<table  width="700" cellpadding="3" cellspacing="5" border=0><tr><td  align=left colspan=2><b>Address for Report #' + (ii+1) + ':</b> &nbsp;<a class="tooltip" href="#">?<span class="ttclassic">You can submit an address you want a report on now, or do so later in the member\'s area after you complete your report credit order below.</span></a>';
				newHtml += '</td></tr>';
				
				newHtml += '<tr><td align="right"><label for="commercial_' + ii + '_no">Residential Property</td><td colspan="2"><table cellspacing="0" width="100%"><tr><td style="width: 120px;"><input class="comm_yn" id="commercial_' + ii + '_no" name="commercial[' + ii + ']" type="radio" value="0" rel="' + ii + '" /><a class="tooltip" href="#">?<span class="ttclassic">Check this box if the property you are doing the report on is residential</i></span></a></td>';
				newHtml += '<td><label for="commercial_' + ii + '_yes">Commercial Property</label> <input id="commercial_' + ii + '_yes" name="commercial[' + ii + ']" type="radio" value="1" rel="' + ii + '" class="comm_yn comm_yes" /> <a class="tooltip" href="#">?<span class="ttclassic">Check this box if the property you are doing the report on is commercial</i></span></a></td>';
				newHtml += '<td valign="middle"><div class="report_price" id="report_price_' + ii + '"><strong>This Address:</strong>&nbsp;<span style="color: green; font-size: 1.6em; font-weight: bold;"></span></div></td></tr></table></td></tr>';
				
				newHtml += '<tr><td align=right style="width: 150px;">Address & Street:</td><td align=left><input class="inputc addr" style="width: 260px;" name="addr[]" value=""> <a class="tooltip" href="#">?<span class="ttclassic">Please Put in the Street Address, City & Zip code for the property you want us to create the Title Report on.  For example:<BR><i>1234 Title St., West Palm Beach 33423</i></span></a></td><td rowspan="5" valign="top" style="width: 220px;"><div class="comm_msg" id="comm_msg_' + ii + '">Commercial properties start at $165 because of their complexity and time to complete. After submitting the order we will email you with an estimate of turnaround time and any additional cost depending on the complexity of the case</div><div class="zip_msg" id="zip_msg_' + ii + '">Reports for properties outside of our coverage fee are assessed a fee of an additional $75.00 each. Additional fees may be assessed and you will be notified if that is the case</div><div class="zip_msg" id="zip_imsg_' + ii + '">You have entered an invalid zip code, please enter a 5 digit zip code with no spaces or letters</div></td></tr><tr><td align=right>Unit:</td><td align=left><input class="inputc addr" style="width: 51px;" name="units[]" value="" /> <a class="tooltip" href="#">?<span class="ttclassic">Please Put in the Street Address, City & Zip code for the property you want us to create the Title Report on.  For example:<BR><i>1234 Title St., West Palm Beach 33423</i></span></a></td></tr>';
				newHtml += '<tr><td align=right>City:</td><td align=left><input style="width: 102px;" class="inputc addr"  name="city[]" value="">';
				newHtml += ' State: <input class="inputc addr" size="2" name="state[]" value=""> Zip: <input class="inputc addr zip" style="width: 43px;" name="ozip[]" value="" rel="' + ii + '"><input class="zc" type="hidden" id="zc' + ii + '" name="zc" value="1" /> <a class="tooltip" href="#">?<span class="ttclassic">Please Put in the Street Address, City & Zip code for the property you want us to create the Title Report on.  For example:<BR><i>1234 Title St., West Palm Beach 33423</i></span></a></td>';
				newHtml += '</tr>';
				
								
				if (jQuery('#reseller').length) {
					newHtml += '<tr><td align=right>Cover Page Info for #' + (ii+1) + ':</td><td><input class="inputc cinfo" size="50" name="cinfo[]" value=""></td></tr>';	
				}
				
				newHtml += '<tr><td align=right><a class="tooltip" href="#" style="margin: 0px; padding: 0px;">Additional Info:<span class="ttclassic">Any additional info about the report you wish to add such as when you need it by, owner name, parcel id or special instructions go here.</span></a></td>';
				newHtml += '<td align=left><input class="inputc ainfo" placeholder="case #, owner name, parcel/tax ID, special instructions" style="width: 260px;" name="ainfo[]" value="">&nbsp;';//<label for="fc_' + (ii+1) + '"><input type="checkbox" id="fc_' + (ii+1) + '" name="foreclosures[]" value="' + (ii+1) + '" class="fcbox" />&nbsp;Foreclosure Auction</label> <a class="tooltip" href="#">?<span class="ttclassic">If this report is for an upcoming foreclosure auction check this box to add a case number and we will explain the lien effects on the auction property.</span></a> </td>';
//				newHtml += '</tr><tr id="casenum' + (ii+1) + '" style="display: none;"><td align="right">Case Number:</td><td><input class="inputc casenum" style="width: 260px;" name="casenum[]" value="" /> ';
				newHtml += '<a class="tooltip" href="#">?<span class="ttclassic">Add the case number for a foreclosure property and we will explain in plain English on the report the auction data.</span></a> </td></tr>';
/*
				
				newHtml += '<tr><td align="right"><input type="checkbox" id="commercial_' + (ii+1) + '" class="commercial" name="commercial[]" value="' + (ii+1) + '" /></td>';
				newHtml += '<td><label for="commercial_' + (ii+1) + '"><B>THIS IS A COMMERCIAL PROPERTY +24-48 hours and $100.00</b> <br> Additional time and payment may be required. </label>&nbsp;<a class="tooltip" href="#">?<span class="ttclassic">Additional cost and time may be required as commercial properties require more research. You will be notified if a report will take more then the additional 24-48 hours and $100.00 listed here.</span></a></td></tr>';
*/
				
				if (rushStatus == 1) {
				
				newHtml += '<tr><td align="right"><input type="checkbox" id="rush_' + ii + '" class="rush" name="rush[]" value="' + ii + '" rel="' + ii + '" /></td><td style="font-size: .9em;"><label for="rush_' + ii + '"><B>RUSH UPGRADE FOR THIS PROPERTY  +$25.00</b> <br> Guaranteed Same Day IF ordered by 3:00 PM M-F </label>&nbsp;<a class="tooltip" href="#">?<span class="ttclassic">If you select this upgrade your order will automatically be jumped ahead of other orders and will be completed same day if ordered by 3pm MON - FRI. Orders placed after 3PM EST will be delivered before 12pm the following business day.</span></a></td></tr>';
				
				/* newHtml += '<tr><td align="right"><input type="checkbox" id="rush_' + (ii+1) + '" class="rush" name="rush[]" value="' + ii + '" /></td><td><label for="rush_' + (ii+1) + '"><B>RUSH UPGRADE FOR THIS PROPERTY  +$25.00</b> <br> Guaranteed Same Day IF ordered by 3:00 PM MON-FRI </label>&nbsp;<a class="tooltip" href="#">?<span class="ttclassic">If you select this upgrade your order will automatically be jumped ahead of other orders and will be completed same day if ordered by 3pm MON - FRI. Orders placed after 3PM EST will be delivered before 12pm the following business day.</span></a></td></tr>'; */
				} else {
				newHtml += '<tr><td align="right"><input DISABLED type="checkbox" id="rush_' + (ii+1) + '" class="rush" name="rush[]" value="' + ii + '" /></td><td><label for="rush_' + (ii+1) + '"><B>RUSH UPGRADE FOR THIS PROPERTY  +$25.00</b> <br><span style="color: #FF0000;">Sold Out Today, Sorry!</span></label>&nbsp;</td></tr>';
					
				}
				newHtml += '</table>';
			
//			s += '<table  width="100%" cellpadding="0" cellspacing="5" border=0> 	<tr>		<td  align=right><font color="#FF3300" size="1">*</font>';
//			s += '<b>Address for Report #' + (ii+1) + ':</b></td><td align=left><input class="inputc addr" size="70" name="addresses[]" value="' + theVal + '"></td></tr>';
//			s += '<tr><td align=right>Additional Info for #' + (ii+1) + ':</td><td><input class="inputc ainfo" size="50" name="ainfo[]" value="">&nbsp;<input type="checkbox" class="fcbox" id="fc_' + ii + '" name="foreclosures[]" value="' + ii + '" />&nbsp;<label for="fc_' + ii + '">Foreclosure Auction?</label></td></tr>';
//			s += '<tr id="casenum' + ii + '" style="display: none;"><td align="right">Case Number:</td><td><input class="inputc casenum" size="50" name="casenum[]" value="" /></td></tr>';
//			s += '</table><table  width="100%" cellpadding="0" cellspacing="5" border=0><tr><td colspan=4 align=center><img src="images/spacer.gif" alt="" width="250" height="10"   border="0" align="right" /></td>	</tr></table>';
		}
		
		jQuery('#addrContainer').html(newHtml);
		jQuery(".fcbox").unbind('click').click(function() {
			jQuery('#casenum' + jQuery(this).val()).toggle();
		});
		
		jQuery('.comm_yn').unbind('click').click(function() {
		 var myIdx = jQuery(this).attr('rel'); 
		 
		 updateReportPrice(myIdx);
	  });
	  
	  jQuery('.rush').unbind('click').click(function() {
		 var myIdx = jQuery(this).attr('rel'); 

		 if ($('#zc' + myIdx).val() == '0') {
			 alert('Orders outside of our coverage area require a minimum of 48 hours, therefore they cannot be rushed.');
			 return false;
		 }


		 updateReportPrice(myIdx);	 
	  });
				
		jQuery('.zip').unbind('blur').blur(function() {
			var myVal = jQuery(this).val();
			var myRel = jQuery(this).attr('rel');

			if (zcTimer == null) {
				//
			} else {
				clearTimeout(zcTimer);
			}
		
			zcTimer = setTimeout('zcLookup(\'' + myVal + '\', \'' + myRel + '\')', 1000);
		});
	});
	
	jQuery(".fcbox").unbind('click').click(function() {
		jQuery('#casenum' + jQuery(this).val()).toggle();
	});

	if (jQuery("#liens_open_1").length) {
		jQuery(".locontainer").hide();
		
		jQuery("input[name=LIENS_OPEN]").click(function() {
			if (jQuery(this).val() == '1') {
				jQuery('#liens_open_0_container').hide();
				jQuery('#liens_open_1_container').show();
			} else {
				jQuery('#liens_open_1_container').hide();
				jQuery('#liens_open_0_container').show();
			}
		});
		
		if (jQuery("input[name=LIENS_OPEN]:checked").val() == '1') {
			jQuery('#liens_open_0_container').hide();
			jQuery('#liens_open_1_container').show();
		} else {
			jQuery('#liens_open_1_container').hide();
			jQuery('#liens_open_0_container').show();
		}
	}
	
	if (jQuery("#fAuction").length) {
		jQuery('#fAuction').click(function() {
			if (jQuery('#fAuction').attr('checked')) {
				jQuery('#fAuctionTable').show();
			} else {
				jQuery('#fAuctionTable').hide();
			}
		});
	}

	if (jQuery("#acct_errors").length) {
		$('html, body').animate({scrollTop: $("#acct_errors").offset().top}, 2000);
	} else if (jQuery("#order_errors").length) {
		$('html, body').animate({scrollTop: $("#order_errors").offset().top}, 2000);
	} else if (jQuery("#billing_errors").length) {
		$('html, body').animate({scrollTop: $("#billing_errors").offset().top}, 2000);
	}
	
	updatePrice();
	
	jQuery("#nr").change(function() {
		updatePrice();
	});
	

	if (jQuery('#aErrors').length) {
		$('html, body').animate({
			scrollTop: $("#aErrors").offset().top
		}, 2000);
	} else if (jQuery('#errors').length) {
		$('html, body').animate({
			scrollTop: $("#errors").offset().top
		}, 2000);
	} else if (jQuery('#bErrors').length) {
		$('html, body').animate({
			scrollTop: $("#bErrors").offset().top
		}, 2000);
	}

	  $(":input[placeholder]").placeholder();
	  
	  jQuery('.comm_yn').click(function() {
		 var myIdx = jQuery(this).attr('rel'); 
		 
		 updateReportPrice(myIdx);
	  });
	  
	  jQuery('.rush').click(function() {
		 var myIdx = jQuery(this).attr('rel'); 
		 
		 if ($('#zc' + myIdx).val() == '0') {
			 alert('Orders outside of our coverage area require a minimum of 48 hours, therefore they cannot be rushed.');
			 return false;
		 }
		 
		 updateReportPrice(myIdx);	 
	  });
	  
	  jQuery('.zip').each(function() {
		 var myIdx = jQuery(this).attr('rel'); 
		  updateReportPrice(myIdx);
	  });
});