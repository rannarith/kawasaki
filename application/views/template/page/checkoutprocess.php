<?php 
    $subprice = [];
    foreach ($list->result() as $key => $result) {
        foreach($accessories->result() as $accessory){ 
            if($result->item_id == $accessory->acs_id){
               $subprice [] = $result->item_price * $result->item_amount;   
            }
        } 
    } 
?>
<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
	<tbody>
		<tr>
			<td height="20" style="line-height:20px" colspan="3"></td>
		</tr>
		<tr>
			<td height="1" colspan="3" style="line-height:1px">
				<div></div>
			</td>
		</tr>
		<tr>
			<td width="15" style="display:block;width:15px"></td>
			<td><table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse"><tbody><tr><td height="15" style="line-height:15px" colspan="3">
			</td>
		</tr>
		<tr>
			<td width="32" align="left" valign="middle" style="height:32;line-height:0px"> <a href="https://www.facebook.com/ads/billing_email/email_actions/?act=1117153191781820&amp;txid=1875538792558304-3870796&amp;tx_type=3&amp;email_action=view_billing_table" style="color:#3b5998;text-decoration:none" target="_blank">
				<img src="<?php echo base_url('assets/images/logo/kawasaki.png') ?>" width="32" height="32" style="border:0"></a> 
			</td>
			<td width="15" style="display:block;width:15px"></td>
			<td width="100%"> 
				<a href="#" style="color:#3b5998;text-decoration:none;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:19px;line-height:32px; text-transform: capitalize;" target="_blank">Receipt for <?php echo $userdatas[0]['first_name'] ." ". $userdatas[0]['last_name'] ?></a> 
			</td>
		</tr>
		<tr style="border-bottom:solid 1px #e5e5e5">
			<td height="15" style="line-height:15px" colspan="3"></td>
		</tr>
	</tbody>
</table>
</td>
<td width="15" style="display:block;width:15px"></td>
</tr>
<tr>
	<td width="15" style="display:block;width:15px"></td>
	<td>
<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
	<tbody>
		<tr>
			<td height="28" style="line-height:28px"></td>
		</tr>
		<tr>
			<td>
				<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
					<tbody>
						<tr>
							<td colspan="2" style="color:#4e5665;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:18px;font-weight:bold;padding:0px 0px 14px 0px"> Summary 
							</td>
						</tr>
						<tr>
							<td rowspan="2" style="padding:0 16px 10px 0;vertical-align:top;width:50%">
								<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
									<tbody>
										<tr>
											<td style="color:#9197a3;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:11px;font-weight:bold"> AMOUNT billed 
											</td>
										</tr>
										<tr>
											<td>
												<div style="color:#63b446;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:36px;font-weight:bold"> 
					                                <?php
					                                    $sub = 0 ;
					                                    foreach ($subprice as $key => $value) {
					                                      
					                                        $sub+= $value;
					                                    }
					                                    echo "$".$sub." USD";
					                                 ?>	
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="padding:0 0 10px 0;vertical-align:top;width:50%">
								<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
									<tbody>
										<tr>
											<td style="color:#9197a3;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:11px;font-weight:bold"> ISSUE DATE 
											</td>
										</tr>
										<tr>
											<td>
												<?php
													$now = new DateTime();
													$now->setTimezone(new DateTimezone('Asia/Bangkok'));
												?>
												<div style="color:#141823;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:14px;font-weight:bold"> <?php echo $now->format('M d, Y, H:i:s:A'); ?></div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td style="padding:0 0 10px 0;vertical-align:top;width:50%">
								<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
									<tbody>
										<tr>
											<td style="color:#9197a3;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:11px;font-weight:bold"> PRODUCT TYPE 
											</td>
										</tr>
										<tr>
											<td>
												<div style="color:#141823;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:14px;font-weight:bold"> KAWASAKI APPAREL </div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td rowspan="2" style="padding:0 16px 10px 0;vertical-align:top;width:50%">
								<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
									<tbody>
										<tr>
											<td style="color:#9197a3;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:11px;font-weight:bold"> Billing REASON 
											</td>
										</tr>
										<tr>
											<td>
												<div style="color:#141823;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:14px;font-weight:bold"> You're not being billed because you payment mathod is cash on hand. 
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="padding:0 0 10px 0;vertical-align:top;width:50%">
								<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
									<tbody>
										<tr>
											<td style="color:#9197a3;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:11px;font-weight:bold"> PAYMENT METHOD 
											</td>
										</tr>
										<tr>
											<td>
												<div style="color:#141823;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:14px;font-weight:bold"> CASH ON HAND </div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td style="padding:0 0 10px 0;vertical-align:top;width:50%"><table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
								<tbody>
									<tr>
										<td style="color:#9197a3;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:11px;font-weight:bold"> CUSTOMER INFORMATION <img title="You can use the reference number to find this charge on your credit card statement." src="https://ci6.googleusercontent.com/proxy/51A06ziVON1_MhR7JURRl2WlC6CjLY9ncSdbe1vzYvReA6nSrFrUnIWDDUatMBkwY9EiobK4BU3XFQFxUgPU7MDW2dlFWDTLeKa5wEP92g=s0-d-e1-ft#https://static.xx.fbcdn.net/rsrc.php/v3/yJ/r/aoz1V35q5np.png" style="border:0;margin:0px 0px 0px 4px">
										</td>
									</tr>
									<tr>
										<td>
											<div style="color:#141823;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:14px;font-weight:bold">
												<table>
													<tr>
														<td>Name:</td>
														<td><p style="margin: 0;text-transform: capitalize;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:13px"><?php echo $userdatas[0]['first_name']. " " .$userdatas[0]['last_name'] ?></p></td>
													</tr>
													<tr>
														<td>Email:</td>
														<td><p style="margin: 0;text-decoration: none; font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:13px"><?php echo $userdatas[0]['email'] ?></p></td>
													</tr>
													<tr>
														<td>Phone:</td>
														<td><p style="margin: 0;text-decoration: none; font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:13px"><?php echo $userdatas[0]['phone_number'] ?></p></td>
													</tr>
													<tr>
														<td>Address:</td>
														<td><p style="margin: 0;text-decoration: none; font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:13px"><?php echo $userdatas[0]['address'] ?></p></td>
													</tr>
												</table>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td height="28" style="line-height:28px">
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
				<tbody>
					<tr>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-bottom:solid 1px #e5e5e5;border-top:solid 1px #e5e5e5">
								<tbody>
									<tr>
										<td style="color:#9197a3;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:11px;font-weight:bold;padding:8px 0 0 0;vertical-align:top"> PRODUCT NAME 
										</td>
										<td style="padding:8px 0 8px 8px;text-align:right">
											<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;display:inline-block;text-align:right">
												<tbody>
													<tr>
														<td style="color:#9197a3;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:11px;font-weight:bold;min-width:120px;padding:0 0 0 8px;vertical-align:top"> SIZE 
														</td>
														<td style="color:#9197a3;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:11px;font-weight:bold;vertical-align:top;padding:0 0 0 8px;min-width:120px"> QTY 
														</td>
														<td style="color:#9197a3;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:11px;font-weight:bold;vertical-align:top;padding:0 0 0 8px;min-width:120px"> SUBTOTAL 
														</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:0 0 8px 0">
							<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
								<tbody>
									<?php 
										foreach ($list->result() as $key => $value) {
											foreach ($accessories->result() as $key => $accessory) {
												if($value->item_id == $accessory->acs_id){ ?>
													<tr>
														<td style="color:#141823;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:14px;padding:8px 0 4px 0;vertical-align:top">
															<img style="border:0;padding:0 8px 0 0" src="https://ci4.googleusercontent.com/proxy/S1Whtrf8zB0iDRQGgd43sueff1VTCBNeJA6PTNJvGlv6YV2EV7Bs1dMvEs35lK4t8JWvTBGjhI7zMi3HmnQFLADHJsJUU1aUI8WOK6xY5g=s0-d-e1-ft#https://static.xx.fbcdn.net/rsrc.php/v3/yj/r/pQkmQzwlV5U.png"> Apparel: "<?php echo $accessory->title; ?>" 
														</td>
														<td style="padding:8px 0 4px 8px;text-align:right">
															<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;display:inline-block;text-align:right">
																<tbody>
																	<tr>
																		<td style="color:#141823;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:14px;font-weight:bold;min-width:120px;padding:0 0 0 16px;vertical-align:top;"><?php echo $value->item_size ?></td>
																		<td style="color:#141823;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:14px;font-weight:bold;min-width:120px"><div> <?php echo $value->item_amount ?> </div>
																		</td>
																		<td style="color:#141823;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:14px;font-weight:bold;min-width:120px;padding:0 0 0 16px;vertical-align:top"> $ <?php echo $value->item_price * $value->item_amount ?></td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
									<?php }}} ?>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-top:solid 1px #e5e5e5">
								<tbody>
									<tr>
										<td style="color:#9197a3;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:11px;font-weight:bold;padding:10px 0 0 0;vertical-align:top"> GRAND TOTAL </td><td style="color:#141823;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:14px;font-weight:bold;padding:8px 0 0 0;text-align:right;vertical-align:top">
			                                <?php
			                                    $sub = 0 ;
			                                    foreach ($subprice as $key => $value) {
			                                      
			                                        $sub+= $value;
			                                    }
			                                    echo "$ ".$sub;
			                                 ?>	
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td height="28" style="line-height:28px">
			
		</td>
	</tr>
</tbody>
</table>
</td>
<td width="15" style="display:block;width:15px">
	
</td>
</tr>
<tr>
<td width="15" style="display:block;width:15px">
	
</td>
<td>
	<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-top:solid 1px #e5e5e5;margin:0px 0px 44px 0px">
		<tbody>
			<tr>
				<td style="min-width:120px">
					<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
						<tbody>
							<tr>
								<td> 
									<span class="m_4945474314488547544mb_text" style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:21px;color:#141823">&nbsp;</span> 
								</td>
							</tr>
							<tr>
								<td> 
									<span class="m_4945474314488547544mb_text" style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:21px;color:#141823">Thanks,</span> 
								</td>
							</tr>
							<tr>
								<td> 
									<span class="m_4945474314488547544mb_text" style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:21px;color:#141823">Kawasaki Team</span> 
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</td>
<td width="15" style="display:block;width:15px">
	
</td>
</tr>
<tr>
	<td width="15" style="display:block;width:15px">
		
	</td>
	<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0" align="left" style="border-collapse:collapse">
			<tbody>
				<tr style="border-top:solid 1px #e5e5e5">
					<td height="19" style="line-height:19px"></td>
				</tr>
				<tr>
					<td style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:11px;color:#aaaaaa;line-height:16px"> This is an automated message. Please do not reply. If you have questions about ads, you can <a href="http://kawasaki.com.kh/page/contact_us" style="color:#3b5998;text-decoration:none" target="_blank">get help</a>. 
					</td>
				</tr>
			</tbody>
		</table>
	</td>
	<td width="15" style="display:block;width:15px"></td>
</tr>
<tr>
	<td width="15" style="display:block;width:15px"></td>
	<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
			<tbody>
			<tr>
				<td style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:11px;color:#aaaaaa;line-height:16px"> 
					<span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:11px;color:#aaaaaa;line-height:16px">To help keep your account secure, please</span> do not forward this email. <span style="font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:11px;color:#aaaaaa;line-height:16px"><a href="http://kawasaki.com.kh/page/allaccessory_part" style="color:#3b5998;text-decoration:none" target="_blank">Learn more.</a></span> 
				</td>
			</tr>
		</tbody>
	</table>
</td>
<td width="15" style="display:block;width:15px">
	
</td>
</tr>
<tr>
	<td height="20" style="line-height:20px" colspan="3"></td>
</tr>
</tbody>
</table>